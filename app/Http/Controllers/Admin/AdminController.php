<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\ContentSection;
use App\Models\Event;
use App\Models\HeroSlide;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\MenuPublication;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class AdminController extends Controller {

    protected function imageUrl(?string $path): ?string {
        if (!$path) {
            return null;
        }
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }
        return asset('storage/' . $path);
    }

    protected function storeImage(?\Illuminate\Http\UploadedFile $file, string $folder): ?string
    {
        if (!$file) {
            return null;
        }

        return $file->store($folder, 'public');
    }

    protected function deleteImageIfExists(?string $path): void
    {
        if ($path && !Str::startsWith($path, ['http://', 'https://', '/'])) {
            Storage::disk('public')->delete($path);
        }
    }

    public function dashboard(): Response
    {
        $settings = SiteSetting::query()->first();

        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'heroSlides' => HeroSlide::query()->count(),
                'sections' => ContentSection::query()->count(),
                'branches' => Branch::query()->count(),
                'events' => Event::query()->count(),
                'categories' => MenuCategory::query()->count(),
                'menuItems' => MenuItem::query()->count(),
                'menuVersion' => $settings?->menu_version ?? 1,
            ],
            'latestPublication' => MenuPublication::query()->latest()->first(),
        ]);
    }

    public function settings(): Response
    {
        $settings = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Zen Japonés',
                'menu_version' => 1,
            ]
        );

        return Inertia::render('Admin/Settings/Index', [
            'settings' => $settings,
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'whatsapp_number' => ['nullable', 'string', 'max:50'],
            'reservation_url' => ['nullable', 'string', 'max:255'],
            'billing_url' => ['nullable', 'string', 'max:255'],
            'privacy_content' => ['nullable', 'string'],
            'jobs_content' => ['nullable', 'string'],
        ]);

        $settings = SiteSetting::query()->firstOrCreate(['id' => 1]);
        $settings->update($data);

        return back()->with('success', 'Configuración actualizada.');
    }

    public function heroSlides(): Response
    {
        $slides = HeroSlide::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($slide) => [
                'id' => $slide->id,
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'image_path' => $slide->image_path,
                'image_url' => $this->imageUrl($slide->image_path),
                'cta_text' => $slide->cta_text,
                'cta_url' => $slide->cta_url,
                'sort_order' => $slide->sort_order,
                'is_active' => $slide->is_active,
            ]);

        return Inertia::render('Admin/HeroSlides/Index', [
            'slides' => $slides,
        ]);
    }

    public function storeHeroSlide(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['required', 'image', 'max:5120'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        HeroSlide::query()->create([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'image_path' => $this->storeImage($request->file('image'), 'hero'),
            'cta_text' => $data['cta_text'] ?? null,
            'cta_url' => $data['cta_url'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Slide creado.');
    }

    public function updateHeroSlide(Request $request, HeroSlide $heroSlide): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $heroSlide->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($heroSlide->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'hero');
        }

        $heroSlide->update([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'image_path' => $imagePath,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_url' => $data['cta_url'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Slide actualizado.');
    }

    public function deleteHeroSlide(HeroSlide $heroSlide): RedirectResponse
    {
        $this->deleteImageIfExists($heroSlide->image_path);
        $heroSlide->delete();

        return back()->with('success', 'Slide eliminado.');
    }

    public function sections(): Response
    {
        $keys = [
            'home_concept',
            'home_experience',
            'home_bar',
            'home_menu_cta',
            'events_banner',
            'jobs_banner',
            'privacy_banner',
        ];

        $sections = ContentSection::query()
            ->whereIn('key', $keys)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($section) => [
                'id' => $section->id,
                'key' => $section->key,
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'content' => $section->content,
                'image_path' => $section->image_path,
                'image_url' => $this->imageUrl($section->image_path),
                'extra_json' => $section->extra_json,
                'is_active' => $section->is_active,
                'sort_order' => $section->sort_order,
            ]);

        return Inertia::render('Admin/ContentSections/Index', [
            'sections' => $sections,
        ]);
    }

    public function updateSection(Request $request, ContentSection $contentSection): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $contentSection->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($contentSection->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'sections');
        }

        $contentSection->update([
            'title' => $data['title'],
            'subtitle' => $data['subtitle'] ?? null,
            'content' => $data['content'] ?? null,
            'image_path' => $imagePath,
            'extra_json' => [
                'button_text' => $data['button_text'] ?? null,
                'button_url' => $data['button_url'] ?? null,
            ],
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Sección actualizada.');
    }

    public function branches(): Response
    {
        $branches = Branch::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($branch) => [
                'id' => $branch->id,
                'name' => $branch->name,
                'slug' => $branch->slug,
                'phone' => $branch->phone,
                'whatsapp' => $branch->whatsapp,
                'email' => $branch->email,
                'address' => $branch->address,
                'city' => $branch->city,
                'state' => $branch->state,
                'postal_code' => $branch->postal_code,
                'maps_url' => $branch->maps_url,
                'hours_text' => $branch->hours_text,
                'description' => $branch->description,
                'image_path' => $branch->image_path,
                'image_url' => $this->imageUrl($branch->image_path),
                'is_active' => $branch->is_active,
                'sort_order' => $branch->sort_order,
            ]);

        return Inertia::render('Admin/Branches/Index', [
            'branches' => $branches,
        ]);
    }

    public function storeBranch(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'maps_url' => ['nullable', 'string', 'max:255'],
            'hours_text' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Branch::query()->create([
            ...$data,
            'slug' => Str::slug($data['name']) . '-' . Str::random(5),
            'image_path' => $this->storeImage($request->file('image'), 'branches'),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Sucursal creada.');
    }

    public function updateBranch(Request $request, Branch $branch): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'maps_url' => ['nullable', 'string', 'max:255'],
            'hours_text' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $branch->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($branch->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'branches');
        }

        $branch->update([
            ...$data,
            'slug' => Str::slug($data['name']) . '-' . $branch->id,
            'image_path' => $imagePath,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Sucursal actualizada.');
    }

    public function deleteBranch(Branch $branch): RedirectResponse
    {
        $this->deleteImageIfExists($branch->image_path);
        $branch->delete();

        return back()->with('success', 'Sucursal eliminada.');
    }

    public function events(): Response
    {
        $events = Event::query()
            ->orderBy('sort_order')
            ->orderByDesc('start_at')
            ->get()
            ->map(fn ($event) => [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'excerpt' => $event->excerpt,
                'description' => $event->description,
                'location' => $event->location,
                'cta_text' => $event->cta_text,
                'cta_url' => $event->cta_url,
                'start_at' => optional($event->start_at)?->format('Y-m-d\TH:i'),
                'end_at' => optional($event->end_at)?->format('Y-m-d\TH:i'),
                'image_path' => $event->image_path,
                'image_url' => $this->imageUrl($event->image_path),
                'is_published' => $event->is_published,
                'sort_order' => $event->sort_order,
            ]);

        return Inertia::render('Admin/Events/Index', [
            'events' => $events,
        ]);
    }

    public function storeEvent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        Event::query()->create([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . Str::random(5),
            'excerpt' => $data['excerpt'] ?? null,
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_url' => $data['cta_url'] ?? null,
            'start_at' => $data['start_at'] ?? null,
            'end_at' => $data['end_at'] ?? null,
            'image_path' => $this->storeImage($request->file('image'), 'events'),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('success', 'Evento creado.');
    }

    public function updateEvent(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $imagePath = $event->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($event->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'events');
        }

        $event->update([
            'title' => $data['title'],
            'slug' => Str::slug($data['title']) . '-' . $event->id,
            'excerpt' => $data['excerpt'] ?? null,
            'description' => $data['description'] ?? null,
            'location' => $data['location'] ?? null,
            'cta_text' => $data['cta_text'] ?? null,
            'cta_url' => $data['cta_url'] ?? null,
            'start_at' => $data['start_at'] ?? null,
            'end_at' => $data['end_at'] ?? null,
            'image_path' => $imagePath,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        return back()->with('success', 'Evento actualizado.');
    }

    public function deleteEvent(Event $event): RedirectResponse
    {
        $this->deleteImageIfExists($event->image_path);
        $event->delete();

        return back()->with('success', 'Evento eliminado.');
    }

    public function menuCategories(): Response
    {
        $categories = MenuCategory::query()
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($category) => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'description' => $category->description,
                'image_path' => $category->image_path,
                'image_url' => $this->imageUrl($category->image_path),
                'is_active' => $category->is_active,
                'sort_order' => $category->sort_order,
            ]);

        return Inertia::render('Admin/MenuCategories/Index', [
            'categories' => $categories,
        ]);
    }

    public function storeMenuCategory(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        MenuCategory::query()->create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . Str::random(5),
            'description' => $data['description'] ?? null,
            'image_path' => $this->storeImage($request->file('image'), 'menu-categories'),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Categoría creada.');
    }

    public function updateMenuCategory(Request $request, MenuCategory $menuCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $imagePath = $menuCategory->image_path;

        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($menuCategory->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'menu-categories');
        }

        $menuCategory->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $menuCategory->id,
            'description' => $data['description'] ?? null,
            'image_path' => $imagePath,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active' => $request->boolean('is_active'),
        ]);

        return back()->with('success', 'Categoría actualizada.');
    }

    public function deleteMenuCategory(MenuCategory $menuCategory): RedirectResponse
    {
        $this->deleteImageIfExists($menuCategory->image_path);
        $menuCategory->delete();

        return back()->with('success', 'Categoría eliminada.');
    }

    public function menuItems(): Response
    {
        $items = MenuItem::query()
            ->with('category')
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($item) => [
                'id' => $item->id,
                'menu_category_id' => $item->menu_category_id,
                'category_name' => $item->category?->name,
                'name' => $item->name,
                'slug' => $item->slug,
                'short_description' => $item->short_description,
                'description' => $item->description,
                'price' => (string) $item->price,
                'promo_price' => $item->promo_price ? (string) $item->promo_price : null,
                'sku' => $item->sku,
                'image_path' => $item->image_path,
                'image_url' => $this->imageUrl($item->image_path),
                'is_featured' => $item->is_featured,
                'is_available' => $item->is_available,
                'is_spicy' => $item->is_spicy,
                'is_vegetarian' => $item->is_vegetarian,
                'is_vegan' => $item->is_vegan,
                'sort_order' => $item->sort_order,
            ]);

        $categories = MenuCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        return Inertia::render('Admin/MenuItems/Index', [
            'items' => $items,
            'categories' => $categories,
        ]);
    }

    public function storeMenuItem(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'promo_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_available' => ['nullable', 'boolean'],
            'is_spicy' => ['nullable', 'boolean'],
            'is_vegetarian' => ['nullable', 'boolean'],
            'is_vegan' => ['nullable', 'boolean'],
        ]);

        MenuItem::query()->create([
            'menu_category_id' => $data['menu_category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . Str::random(5),
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'promo_price' => $data['promo_price'] ?? null,
            'sku' => $data['sku'] ?? null,
            'image_path' => $this->storeImage($request->file('image'), 'menu-items'),
            'sort_order' => $data['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_available' => $request->boolean('is_available'),
            'is_spicy' => $request->boolean('is_spicy'),
            'is_vegetarian' => $request->boolean('is_vegetarian'),
            'is_vegan' => $request->boolean('is_vegan'),
        ]);
        return back()->with('success', 'Platillo creado.');
    }

    public function updateMenuItem(Request $request, MenuItem $menuItem): RedirectResponse
    {
        $data = $request->validate([
            'menu_category_id' => ['required', 'exists:menu_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'promo_price' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', 'max:100'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
            'is_available' => ['nullable', 'boolean'],
            'is_spicy' => ['nullable', 'boolean'],
            'is_vegetarian' => ['nullable', 'boolean'],
            'is_vegan' => ['nullable', 'boolean'],
        ]);
        $imagePath = $menuItem->image_path;
        if ($request->hasFile('image')) {
            $this->deleteImageIfExists($menuItem->image_path);
            $imagePath = $this->storeImage($request->file('image'), 'menu-items');
        }
        $menuItem->update([
            'menu_category_id' => $data['menu_category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . $menuItem->id,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'price' => $data['price'],
            'promo_price' => $data['promo_price'] ?? null,
            'sku' => $data['sku'] ?? null,
            'image_path' => $imagePath,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_available' => $request->boolean('is_available'),
            'is_spicy' => $request->boolean('is_spicy'),
            'is_vegetarian' => $request->boolean('is_vegetarian'),
            'is_vegan' => $request->boolean('is_vegan'),
        ]);
        return back()->with('success', 'Platillo actualizado.');
    }

    public function deleteMenuItem(MenuItem $menuItem): RedirectResponse
    {
        $this->deleteImageIfExists($menuItem->image_path);
        $menuItem->delete();
        return back()->with('success', 'Platillo eliminado.');
    }

    public function publishMenu(Request $request): RedirectResponse
    {
        $settings = SiteSetting::query()->firstOrCreate(
            ['id' => 1],
            ['site_name' => 'Zen Japonés', 'menu_version' => 1]
        );
        $newVersion = ((int) $settings->menu_version) + 1;
        $settings->update([
            'menu_version' => $newVersion,
            'last_published_at' => now(),
        ]);
        MenuPublication::query()->create([
            'version_number' => $newVersion,
            'published_by' => Auth::id(),
            'notes' => $request->input('notes'),
        ]);
        return back()->with('success', 'Menú publicado.');
    }

}
