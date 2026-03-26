<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ContentSection;
use App\Models\Event;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use Inertia\Inertia;
use Inertia\Response;

class PublicSiteController extends Controller {

    protected function imageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }
        return asset('storage/' . $path);
    }

    protected function sectionByKey(string $key): ?array
    {
        $section = ContentSection::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();
        if (!$section) {
            return null;
        }
        return [
            'key' => $section->key,
            'title' => $section->title,
            'subtitle' => $section->subtitle,
            'content' => $section->content,
            'image_path' => $this->imageUrl($section->image_path),
            'extra_json' => $section->extra_json,
        ];
    }

    public function home(): Response {
        $slides = HeroSlide::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($slide) => [
                'title' => $slide->title,
                'subtitle' => $slide->subtitle,
                'image' => $this->imageUrl($slide->image_path),
                'cta' => $slide->cta_text,
                'ctaHref' => $slide->cta_url,
            ])
            ->values();
        return Inertia::render('Public/Home', [
            'slides' => $slides,
            'conceptSection' => $this->sectionByKey('home_concept'),
            'experienceSection' => $this->sectionByKey('home_experience'),
            'barSection' => $this->sectionByKey('home_bar'),
            'menuCtaSection' => $this->sectionByKey('home_menu_cta'),
        ]);
    }

    public function branches(): Response {
        $branches = Branch::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(fn ($branch) => [
                'name' => $branch->name,
                'phone' => $branch->phone,
                'address' => $branch->address,
                'hours_text' => $branch->hours_text,
                'maps_url' => $branch->maps_url,
                'image_path' => $this->imageUrl($branch->image_path),
                'description' => $branch->description,
            ])
            ->values();
        return Inertia::render('Public/Branches/Index', [
            'branches' => $branches,
        ]);
    }

    public function menu(): Response {
        return Inertia::render('Public/Menu/Index');
    }

    public function events(): Response {
        $events = Event::query()
            ->where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('start_at')
            ->get()
            ->map(fn ($event) => [
                'title' => $event->title,
                'excerpt' => $event->excerpt,
                'description' => $event->description,
                'image_path' => $this->imageUrl($event->image_path),
                'start_at' => optional($event->start_at)?->format('d/m/Y H:i'),
                'end_at' => optional($event->end_at)?->format('d/m/Y H:i'),
                'location' => $event->location,
                'cta_text' => $event->cta_text,
                'cta_url' => $event->cta_url,
            ])
            ->values();
        $banner = $this->sectionByKey('events_banner');
        return Inertia::render('Public/Events/Index', [
            'events' => $events,
            'banner' => $banner,
        ]);
    }

    public function privacy(): Response {
        $settings = SiteSetting::query()->first();
        return Inertia::render('Public/Privacy/Show', [
            'content' => $settings?->privacy_content,
            'banner' => $this->sectionByKey('privacy_banner'),
        ]);
    }

    public function jobs(): Response {
        $settings = SiteSetting::query()->first();
        return Inertia::render('Public/Jobs/Show', [
            'content' => $settings?->jobs_content,
            'banner' => $this->sectionByKey('jobs_banner'),
        ]);
    }

}
