<script setup lang="ts">
import AdminLayout from '@/layouts/AdminLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue'
import { ImagePlus, Pencil, Plus, Search, Trash2, X } from 'lucide-vue-next'

defineOptions({
    layout: AdminLayout,
})

interface Category {
    id: number
    name: string
}

interface MenuItem {
    id: number
    menu_category_id: number
    name: string
    slug: string
    short_description: string | null
    description: string | null
    price: number | string
    promo_price: number | string | null
    sku: string | null
    image_path: string | null
    is_featured: boolean
    is_available: boolean
    is_spicy: boolean
    is_vegetarian: boolean
    is_vegan: boolean
    sort_order: number
    published_at: string | null
    category_name?: string
}

const props = defineProps<{
    items: MenuItem[]
    categories: Category[]
}>()

const search = ref('')
const modalOpen = ref(false)
const editingId = ref<number | null>(null)
const previewUrl = ref<string | null>(null)

const form = useForm({
    menu_category_id: '',
    name: '',
    slug: '',
    short_description: '',
    description: '',
    price: '',
    promo_price: '',
    sku: '',
    image: null as File | null,
    is_featured: false,
    is_available: true,
    is_spicy: false,
    is_vegetarian: false,
    is_vegan: false,
    sort_order: '0',
})

const filteredItems = computed(() => {
    const term = search.value.trim().toLowerCase()

    if (!term) return props.items

    return props.items.filter((item) => {
        return (
            item.name.toLowerCase().includes(term) ||
            (item.category_name ?? '').toLowerCase().includes(term) ||
            (item.slug ?? '').toLowerCase().includes(term) ||
            (item.short_description ?? '').toLowerCase().includes(term)
        )
    })
})

function openCreateModal() {
    editingId.value = null
    previewUrl.value = null
    form.reset()
    form.menu_category_id = ''
    form.is_available = true
    form.is_featured = false
    form.is_spicy = false
    form.is_vegetarian = false
    form.is_vegan = false
    form.sort_order = '0'
    modalOpen.value = true
}

function openEditModal(item: MenuItem) {
    editingId.value = item.id
    previewUrl.value = item.image_path
    form.menu_category_id = String(item.menu_category_id)
    form.name = item.name ?? ''
    form.slug = item.slug ?? ''
    form.short_description = item.short_description ?? ''
    form.description = item.description ?? ''
    form.price = String(item.price ?? '')
    form.promo_price = item.promo_price ? String(item.promo_price) : ''
    form.sku = item.sku ?? ''
    form.image = null
    form.is_featured = Boolean(item.is_featured)
    form.is_available = Boolean(item.is_available)
    form.is_spicy = Boolean(item.is_spicy)
    form.is_vegetarian = Boolean(item.is_vegetarian)
    form.is_vegan = Boolean(item.is_vegan)
    form.sort_order = String(item.sort_order ?? 0)
    modalOpen.value = true
}

function closeModal() {
    modalOpen.value = false
    editingId.value = null
    previewUrl.value = null
    form.reset()
    form.clearErrors()
}

function onFileChange(event: Event) {
    const target = event.target as HTMLInputElement
    const file = target.files?.[0] ?? null
    form.image = file

    if (file) {
        previewUrl.value = URL.createObjectURL(file)
    }
}

function submitForm() {
    if (editingId.value) {
        form.post(route('admin.menu-items.update', editingId.value), {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => closeModal(),
        })
        return
    }

    form.post(route('admin.menu-items.store'), {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: () => closeModal(),
    })
}

function destroyItem(item: MenuItem) {
    if (!confirm(`¿Eliminar "${item.name}"?`)) return

    router.delete(route('admin.menu-items.destroy', item.id), {
        preserveScroll: true,
    })
}

function autoSlug() {
    form.slug = form.name
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '')
}
</script>

<template>
    <Head title="Platillos del menú" />

    <div class="space-y-6">
        <div class="rounded-3xl border border-white/10 bg-white/5 p-4 shadow-2xl backdrop-blur md:p-6">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.25em] text-amber-400">Admin · Menú</p>
                    <h1 class="mt-2 text-2xl font-semibold text-white md:text-3xl">Platillos del menú</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-7 text-white/70">
                        Administra categorías, precios, disponibilidad, atributos especiales e imagen principal de cada platillo.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <div class="relative">
                        <Search class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-white/40" />
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar platillo..."
                            class="w-full rounded-2xl border border-white/10 bg-black/30 py-3 pl-10 pr-4 text-sm text-white outline-none transition focus:border-amber-400 sm:w-72"
                        />
                    </div>

                    <button
                        type="button"
                        @click="openCreateModal"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl bg-amber-400 px-5 py-3 text-sm font-semibold text-black transition hover:scale-[1.02]"
                    >
                        <Plus class="h-4 w-4" />
                        Nuevo platillo
                    </button>
                </div>
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-white/60">Total platillos</p>
                <p class="mt-3 text-3xl font-bold text-white">{{ items.length }}</p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-white/60">Disponibles</p>
                <p class="mt-3 text-3xl font-bold text-emerald-400">
                    {{ items.filter(i => i.is_available).length }}
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-white/60">Destacados</p>
                <p class="mt-3 text-3xl font-bold text-amber-400">
                    {{ items.filter(i => i.is_featured).length }}
                </p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                <p class="text-sm text-white/60">Categorías</p>
                <p class="mt-3 text-3xl font-bold text-white">{{ categories.length }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-2xl backdrop-blur">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-black/30 text-white/60">
                        <tr>
                            <th class="px-4 py-4 font-medium">Imagen</th>
                            <th class="px-4 py-4 font-medium">Platillo</th>
                            <th class="px-4 py-4 font-medium">Categoría</th>
                            <th class="px-4 py-4 font-medium">Precio</th>
                            <th class="px-4 py-4 font-medium">Estado</th>
                            <th class="px-4 py-4 font-medium">Atributos</th>
                            <th class="px-4 py-4 font-medium text-right">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in filteredItems"
                            :key="item.id"
                            class="border-t border-white/10 text-white/85 transition hover:bg-white/5"
                        >
                            <td class="px-4 py-4">
                                <div class="h-16 w-16 overflow-hidden rounded-2xl border border-white/10 bg-black/30">
                                    <img
                                        v-if="item.image_path"
                                        :src="item.image_path"
                                        :alt="item.name"
                                        class="h-full w-full object-cover"
                                    />
                                    <div v-else class="flex h-full w-full items-center justify-center text-xs text-white/30">
                                        Sin imagen
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div>
                                    <p class="font-semibold text-white">{{ item.name }}</p>
                                    <p class="mt-1 text-xs text-white/50">{{ item.slug }}</p>
                                    <p v-if="item.short_description" class="mt-2 line-clamp-2 max-w-xs text-xs text-white/60">
                                        {{ item.short_description }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <span class="rounded-full border border-white/10 bg-black/30 px-3 py-1 text-xs text-white/80">
                                    {{ item.category_name || '—' }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <div class="space-y-1">
                                    <p class="font-semibold text-amber-400">${{ item.price }}</p>
                                    <p v-if="item.promo_price" class="text-xs text-emerald-400">
                                        Promo: ${{ item.promo_price }}
                                    </p>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <span
                                    class="rounded-full px-3 py-1 text-xs font-medium"
                                    :class="item.is_available
                                        ? 'bg-emerald-500/15 text-emerald-400 ring-1 ring-emerald-500/20'
                                        : 'bg-red-500/15 text-red-400 ring-1 ring-red-500/20'"
                                >
                                    {{ item.is_available ? 'Disponible' : 'No disponible' }}
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <span v-if="item.is_featured" class="rounded-full bg-amber-400/15 px-3 py-1 text-xs text-amber-400">
                                        Destacado
                                    </span>
                                    <span v-if="item.is_spicy" class="rounded-full bg-red-500/15 px-3 py-1 text-xs text-red-400">
                                        Picante
                                    </span>
                                    <span v-if="item.is_vegetarian" class="rounded-full bg-lime-500/15 px-3 py-1 text-xs text-lime-400">
                                        Vegetariano
                                    </span>
                                    <span v-if="item.is_vegan" class="rounded-full bg-emerald-500/15 px-3 py-1 text-xs text-emerald-400">
                                        Vegano
                                    </span>
                                </div>
                            </td>

                            <td class="px-4 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        type="button"
                                        @click="openEditModal(item)"
                                        class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-black/30 px-3 py-2 text-xs text-white transition hover:border-amber-400 hover:text-amber-400"
                                    >
                                        <Pencil class="h-4 w-4" />
                                        Editar
                                    </button>

                                    <button
                                        type="button"
                                        @click="destroyItem(item)"
                                        class="inline-flex items-center gap-2 rounded-xl border border-red-500/20 bg-red-500/10 px-3 py-2 text-xs text-red-400 transition hover:bg-red-500/20"
                                    >
                                        <Trash2 class="h-4 w-4" />
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr v-if="!filteredItems.length">
                            <td colspan="7" class="px-4 py-12 text-center text-white/50">
                                No hay resultados para tu búsqueda.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="opacity-0 scale-95"
            enter-to-class="opacity-100 scale-100"
            leave-active-class="transition duration-150 ease-in"
            leave-from-class="opacity-100 scale-100"
            leave-to-class="opacity-0 scale-95"
        >
            <div
                v-if="modalOpen"
                class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4 backdrop-blur-sm"
            >
                <div class="max-h-[92vh] w-full max-w-5xl overflow-y-auto rounded-3xl border border-white/10 bg-neutral-950 shadow-2xl">
                    <div class="sticky top-0 z-10 flex items-center justify-between border-b border-white/10 bg-neutral-950/95 px-5 py-4 backdrop-blur md:px-6">
                        <div>
                            <p class="text-sm uppercase tracking-[0.25em] text-amber-400">
                                {{ editingId ? 'Editar platillo' : 'Nuevo platillo' }}
                            </p>
                            <h2 class="mt-1 text-xl font-semibold text-white">
                                {{ editingId ? 'Actualizar información del platillo' : 'Crear un nuevo platillo' }}
                            </h2>
                        </div>

                        <button
                            type="button"
                            @click="closeModal"
                            class="rounded-2xl border border-white/10 bg-black/30 p-2 text-white/70 transition hover:text-white"
                        >
                            <X class="h-5 w-5" />
                        </button>
                    </div>

                    <form @submit.prevent="submitForm" class="space-y-8 p-5 md:p-6">
                        <div class="grid gap-6 lg:grid-cols-[1fr_340px]">
                            <div class="space-y-6">
                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Nombre</label>
                                        <input
                                            v-model="form.name"
                                            @blur="autoSlug"
                                            type="text"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="Ej. Ramen Tonkotsu"
                                        />
                                        <p v-if="form.errors.name" class="mt-2 text-xs text-red-400">{{ form.errors.name }}</p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Slug</label>
                                        <input
                                            v-model="form.slug"
                                            type="text"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="ramen-tonkotsu"
                                        />
                                        <p v-if="form.errors.slug" class="mt-2 text-xs text-red-400">{{ form.errors.slug }}</p>
                                    </div>
                                </div>

                                <div class="grid gap-4 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Categoría</label>
                                        <select
                                            v-model="form.menu_category_id"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                        >
                                            <option value="">Selecciona una categoría</option>
                                            <option v-for="category in categories" :key="category.id" :value="String(category.id)">
                                                {{ category.name }}
                                            </option>
                                        </select>
                                        <p v-if="form.errors.menu_category_id" class="mt-2 text-xs text-red-400">
                                            {{ form.errors.menu_category_id }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">SKU</label>
                                        <input
                                            v-model="form.sku"
                                            type="text"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="SKU-001"
                                        />
                                        <p v-if="form.errors.sku" class="mt-2 text-xs text-red-400">{{ form.errors.sku }}</p>
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-white">Descripción corta</label>
                                    <textarea
                                        v-model="form.short_description"
                                        rows="3"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                        placeholder="Texto breve para cards o listados..."
                                    />
                                    <p v-if="form.errors.short_description" class="mt-2 text-xs text-red-400">
                                        {{ form.errors.short_description }}
                                    </p>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-white">Descripción completa</label>
                                    <textarea
                                        v-model="form.description"
                                        rows="5"
                                        class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                        placeholder="Descripción detallada del platillo..."
                                    />
                                    <p v-if="form.errors.description" class="mt-2 text-xs text-red-400">
                                        {{ form.errors.description }}
                                    </p>
                                </div>

                                <div class="grid gap-4 md:grid-cols-3">
                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Precio</label>
                                        <input
                                            v-model="form.price"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="0.00"
                                        />
                                        <p v-if="form.errors.price" class="mt-2 text-xs text-red-400">{{ form.errors.price }}</p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Precio promo</label>
                                        <input
                                            v-model="form.promo_price"
                                            type="number"
                                            step="0.01"
                                            min="0"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="0.00"
                                        />
                                        <p v-if="form.errors.promo_price" class="mt-2 text-xs text-red-400">
                                            {{ form.errors.promo_price }}
                                        </p>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-medium text-white">Orden</label>
                                        <input
                                            v-model="form.sort_order"
                                            type="number"
                                            min="0"
                                            class="w-full rounded-2xl border border-white/10 bg-black/30 px-4 py-3 text-white outline-none transition focus:border-amber-400"
                                            placeholder="0"
                                        />
                                        <p v-if="form.errors.sort_order" class="mt-2 text-xs text-red-400">
                                            {{ form.errors.sort_order }}
                                        </p>
                                    </div>
                                </div>

                                <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-5">
                                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white/80">
                                        <input v-model="form.is_available" type="checkbox" class="rounded border-white/20 bg-black/30 text-amber-400 focus:ring-amber-400" />
                                        Disponible
                                    </label>

                                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white/80">
                                        <input v-model="form.is_featured" type="checkbox" class="rounded border-white/20 bg-black/30 text-amber-400 focus:ring-amber-400" />
                                        Destacado
                                    </label>

                                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white/80">
                                        <input v-model="form.is_spicy" type="checkbox" class="rounded border-white/20 bg-black/30 text-amber-400 focus:ring-amber-400" />
                                        Picante
                                    </label>

                                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white/80">
                                        <input v-model="form.is_vegetarian" type="checkbox" class="rounded border-white/20 bg-black/30 text-amber-400 focus:ring-amber-400" />
                                        Vegetariano
                                    </label>

                                    <label class="flex items-center gap-3 rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-white/80">
                                        <input v-model="form.is_vegan" type="checkbox" class="rounded border-white/20 bg-black/30 text-amber-400 focus:ring-amber-400" />
                                        Vegano
                                    </label>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div class="rounded-3xl border border-white/10 bg-black/20 p-4">
                                    <p class="mb-3 text-sm font-medium text-white">Imagen principal</p>

                                    <label class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border border-dashed border-white/15 bg-black/30 p-6 text-center transition hover:border-amber-400/60">
                                        <ImagePlus class="h-8 w-8 text-white/50" />
                                        <span class="mt-3 text-sm text-white/70">Subir imagen</span>
                                        <span class="mt-1 text-xs text-white/40">PNG, JPG, WEBP</span>
                                        <input type="file" accept="image/*" class="hidden" @change="onFileChange" />
                                    </label>

                                    <p v-if="form.errors.image" class="mt-2 text-xs text-red-400">{{ form.errors.image }}</p>

                                    <div class="mt-4 overflow-hidden rounded-3xl border border-white/10 bg-black/30">
                                        <img
                                            v-if="previewUrl"
                                            :src="previewUrl"
                                            alt="Vista previa"
                                            class="h-72 w-full object-cover"
                                        />
                                        <div v-else class="flex h-72 items-center justify-center text-sm text-white/30">
                                            Sin vista previa
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-3xl border border-white/10 bg-white/5 p-4">
                                    <h3 class="text-sm font-semibold text-white">Sugerencias</h3>
                                    <ul class="mt-3 space-y-2 text-xs leading-6 text-white/60">
                                        <li>• Usa nombres claros y slug limpio.</li>
                                        <li>• Sube imágenes con nombre único.</li>
                                        <li>• Usa promo solo si realmente aplica.</li>
                                        <li>• Mantén el orden para que el menú salga bien.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-white/10 pt-5 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                @click="closeModal"
                                class="rounded-2xl border border-white/10 bg-black/30 px-5 py-3 text-sm font-medium text-white/80 transition hover:text-white"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-2xl bg-amber-400 px-5 py-3 text-sm font-semibold text-black transition hover:scale-[1.02] disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                {{ form.processing ? 'Guardando...' : (editingId ? 'Actualizar platillo' : 'Guardar platillo') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </transition>
    </div>
</template>
