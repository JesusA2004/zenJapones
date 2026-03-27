<script setup lang="ts">
import { computed, ref } from 'vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import ImageUploader from '@/components/Admin/ImageUploader.vue'
import { useForm, router } from '@inertiajs/vue3'
import Swal from 'sweetalert2'
import {
    LoaderCircle,
    Pencil,
    Trash2,
    ImagePlus,
    BadgePlus,
    Eye,
    EyeOff,
    LayoutPanelTop,
    Sparkles,
    ArrowUpDown,
    Link2,
    Type,
    Text,
} from 'lucide-vue-next'

defineOptions({
    layout: (h: any, page: any) => h(AdminLayout, {}, () => page),
})

type SlideItem = {
    id: number
    title: string | null
    subtitle: string | null
    image_url: string | null
    image?: File | null
    cta_text: string | null
    cta_url: string | null
    sort_order: number | null
    is_active: boolean
}

const props = defineProps<{
    slides: SlideItem[]
}>()

const isGlobalUploading = ref(false)
const currentActionText = ref('Procesando...')
const updatingSlideId = ref<number | null>(null)
const deletingSlideId = ref<number | null>(null)

const createForm = useForm({
    title: '',
    subtitle: '',
    image: null as File | null,
    cta_text: '',
    cta_url: '',
    sort_order: 0,
    is_active: true,
})

const localSlides = ref<SlideItem[]>(
    props.slides.map((slide) => ({
        ...slide,
        image: null,
        title: slide.title ?? '',
        subtitle: slide.subtitle ?? '',
        cta_text: slide.cta_text ?? '',
        cta_url: slide.cta_url ?? '',
        sort_order: slide.sort_order ?? 0,
        is_active: Boolean(slide.is_active),
    })),
)

const hasSlides = computed(() => localSlides.value.length > 0)

const inputClass =
    'w-full rounded-2xl border border-zinc-700/80 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 placeholder:text-zinc-500 outline-none transition duration-300 focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 hover:border-zinc-500'

const textareaClass =
    'w-full rounded-2xl border border-zinc-700/80 bg-zinc-900/80 px-4 py-3 text-sm text-zinc-100 placeholder:text-zinc-500 outline-none transition duration-300 focus:border-amber-400 focus:ring-4 focus:ring-amber-400/10 hover:border-zinc-500 resize-none'

const panelClass =
    'rounded-3xl border border-zinc-800 bg-zinc-950/80 backdrop-blur-xl shadow-[0_10px_40px_rgba(0,0,0,.35)]'

const cardClass =
    'group overflow-hidden rounded-3xl border border-zinc-800 bg-zinc-950/90 backdrop-blur-xl shadow-[0_10px_30px_rgba(0,0,0,.30)] transition duration-300 hover:-translate-y-1 hover:border-amber-400/30 hover:shadow-[0_16px_40px_rgba(0,0,0,.45)]'

function setUploadingState(status: boolean, text = 'Procesando...') {
    isGlobalUploading.value = status
    currentActionText.value = text
}

function resetCreateForm() {
    createForm.reset()
    createForm.title = ''
    createForm.subtitle = ''
    createForm.image = null
    createForm.cta_text = ''
    createForm.cta_url = ''
    createForm.sort_order = 0
    createForm.is_active = true
}

async function createSlide() {
    if (!createForm.title?.trim()) {
        await Swal.fire({
            icon: 'warning',
            title: 'Falta el título',
            text: 'El título del slide es obligatorio.',
            confirmButtonText: 'Entendido',
            background: '#18181b',
            color: '#fafafa',
            confirmButtonColor: '#f59e0b',
        })
        return
    }

    if (!createForm.image) {
        await Swal.fire({
            icon: 'warning',
            title: 'Falta la imagen',
            text: 'Debes seleccionar una imagen para crear el slide.',
            confirmButtonText: 'Entendido',
            background: '#18181b',
            color: '#fafafa',
            confirmButtonColor: '#f59e0b',
        })
        return
    }

    setUploadingState(true, 'Espere, se está subiendo el slide...')

    createForm.post('/admin/hero-slides', {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: async () => {
            resetCreateForm()
            await Swal.fire({
                icon: 'success',
                title: 'Slide creado',
                text: 'El slide se guardó correctamente.',
                timer: 1800,
                showConfirmButton: false,
                background: '#18181b',
                color: '#fafafa',
            })
        },
        onError: async () => {
            await Swal.fire({
                icon: 'error',
                title: 'No se pudo guardar',
                text: 'Revise los campos e inténtelo de nuevo.',
                confirmButtonText: 'Cerrar',
                background: '#18181b',
                color: '#fafafa',
                confirmButtonColor: '#f59e0b',
            })
        },
        onFinish: () => {
            setUploadingState(false)
        },
    })
}

async function updateSlide(slide: SlideItem) {
    if (!slide.title?.trim()) {
        await Swal.fire({
            icon: 'warning',
            title: 'Falta el título',
            text: 'El título del slide es obligatorio.',
            confirmButtonText: 'Entendido',
            background: '#18181b',
            color: '#fafafa',
            confirmButtonColor: '#f59e0b',
        })
        return
    }

    const result = await Swal.fire({
        icon: 'question',
        title: '¿Actualizar slide?',
        text: 'Se guardarán los cambios realizados.',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        background: '#18181b',
        color: '#fafafa',
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#3f3f46',
    })

    if (!result.isConfirmed) return

    updatingSlideId.value = slide.id
    setUploadingState(true, 'Espere, se está actualizando el slide...')

    const formData = new FormData()
    formData.append('title', slide.title ?? '')
    formData.append('subtitle', slide.subtitle ?? '')
    formData.append('cta_text', slide.cta_text ?? '')
    formData.append('cta_url', slide.cta_url ?? '')
    formData.append('sort_order', String(slide.sort_order ?? 0))
    formData.append('is_active', slide.is_active ? '1' : '0')

    if (slide.image) {
        formData.append('image', slide.image)
    }

    router.post(`/admin/hero-slides/${slide.id}`, formData, {
        forceFormData: true,
        preserveScroll: true,
        onSuccess: async () => {
            slide.image = null
            await Swal.fire({
                icon: 'success',
                title: 'Slide actualizado',
                text: 'Los cambios se guardaron correctamente.',
                timer: 1800,
                showConfirmButton: false,
                background: '#18181b',
                color: '#fafafa',
            })
        },
        onError: async () => {
            await Swal.fire({
                icon: 'error',
                title: 'No se pudo actualizar',
                text: 'Revise la información capturada.',
                confirmButtonText: 'Cerrar',
                background: '#18181b',
                color: '#fafafa',
                confirmButtonColor: '#f59e0b',
            })
        },
        onFinish: () => {
            updatingSlideId.value = null
            setUploadingState(false)
        },
    })
}

async function destroySlide(id: number) {
    const result = await Swal.fire({
        icon: 'warning',
        title: '¿Eliminar slide?',
        text: 'Esta acción no se puede deshacer.',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#3f3f46',
        background: '#18181b',
        color: '#fafafa',
    })

    if (!result.isConfirmed) return

    deletingSlideId.value = id
    setUploadingState(true, 'Espere, se está eliminando el slide...')

    router.delete(`/admin/hero-slides/${id}`, {
        preserveScroll: true,
        onSuccess: async () => {
            await Swal.fire({
                icon: 'success',
                title: 'Slide eliminado',
                text: 'El registro fue eliminado correctamente.',
                timer: 1600,
                showConfirmButton: false,
                background: '#18181b',
                color: '#fafafa',
            })
        },
        onError: async () => {
            await Swal.fire({
                icon: 'error',
                title: 'No se pudo eliminar',
                text: 'Ocurrió un problema al intentar borrar el slide.',
                confirmButtonText: 'Cerrar',
                background: '#18181b',
                color: '#fafafa',
                confirmButtonColor: '#f59e0b',
            })
        },
        onFinish: () => {
            deletingSlideId.value = null
            setUploadingState(false)
        },
    })
}
</script>

<template>
    <div class="relative min-h-screen space-y-6 bg-gradient-to-br from-zinc-950 via-zinc-900 to-black p-1 text-zinc-100">
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition duration-200 ease-in"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="isGlobalUploading"
                class="fixed inset-0 z-[999] flex items-center justify-center bg-black/75 px-4 backdrop-blur-md"
            >
                <div class="w-full max-w-sm rounded-[28px] border border-zinc-800 bg-zinc-950/95 p-7 text-center shadow-2xl">
                    <div class="mx-auto mb-5 flex h-20 w-20 items-center justify-center rounded-full border border-amber-400/20 bg-amber-400/10">
                        <LoaderCircle class="h-9 w-9 animate-spin text-amber-400" />
                    </div>

                    <h3 class="text-xl font-semibold tracking-tight text-white">Procesando</h3>
                    <p class="mt-2 text-sm leading-relaxed text-zinc-400">
                        {{ currentActionText }}
                    </p>
                </div>
            </div>
        </transition>

        <div
            class="relative overflow-hidden rounded-[32px] border border-zinc-800 bg-gradient-to-r from-zinc-950 via-zinc-900 to-zinc-950 p-6 shadow-[0_10px_40px_rgba(0,0,0,.35)]"
        >
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(245,158,11,0.12),transparent_28%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,255,255,0.04),transparent_24%)]"></div>

            <div class="relative flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-3">
                    <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/20 bg-amber-400/10 px-3 py-1 text-xs font-medium text-amber-300">
                        <Sparkles class="h-3.5 w-3.5" />
                        Panel de administración
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">
                            Gestión de Hero Slides
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="inline-flex items-center gap-2 rounded-2xl border border-zinc-700 bg-zinc-900/80 px-4 py-3 text-sm font-medium text-zinc-200">
                        <LayoutPanelTop class="h-4 w-4 text-amber-400" />{{ localSlides.length }} slide<span v-if="localSlides.length > 1">s</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-[430px_1fr] 2xl:grid-cols-[470px_1fr]">
            <form
                @submit.prevent="createSlide"
                :class="panelClass"
                class="space-y-6 p-5 sm:p-6"
            >
                <div class="flex items-start gap-4">
                    <div class="rounded-2xl border border-amber-400/20 bg-amber-400/10 p-3 text-amber-400">
                        <BadgePlus class="h-5 w-5" />
                    </div>

                    <div>
                        <h2 class="text-xl font-semibold text-white">Nuevo slide</h2>
                        <p class="mt-1 text-sm text-zinc-400">
                            Captura la información y publica un nuevo elemento para el hero.
                        </p>
                    </div>
                </div>

                <div class="grid gap-5">
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-zinc-300">
                            <Type class="h-4 w-4 text-amber-400" />
                            Título *
                        </label>
                        <input
                            v-model="createForm.title"
                            type="text"
                            placeholder="Ej. Vive la experiencia Zen"
                            :class="inputClass"
                        />
                        <p v-if="createForm.errors.title" class="text-sm text-rose-400">
                            {{ createForm.errors.title }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-zinc-300">
                            <Text class="h-4 w-4 text-amber-400" />
                            Subtítulo <span class="text-zinc-500">(opcional)</span>
                        </label>
                        <textarea
                            v-model="createForm.subtitle"
                            rows="4"
                            placeholder="Texto descriptivo del slide"
                            :class="textareaClass"
                        />
                        <p v-if="createForm.errors.subtitle" class="text-sm text-rose-400">
                            {{ createForm.errors.subtitle }}
                        </p>
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-300">
                                Texto del botón <span class="text-zinc-500">(opcional)</span>
                            </label>
                            <input
                                v-model="createForm.cta_text"
                                type="text"
                                placeholder="Reservar ahora"
                                :class="inputClass"
                            />
                            <p v-if="createForm.errors.cta_text" class="text-sm text-rose-400">
                                {{ createForm.errors.cta_text }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="flex items-center gap-2 text-sm font-medium text-zinc-300">
                                <ArrowUpDown class="h-4 w-4 text-amber-400" />
                                Orden <span class="text-zinc-500">(opcional)</span>
                            </label>
                            <input
                                v-model="createForm.sort_order"
                                type="number"
                                min="0"
                                placeholder="0"
                                :class="inputClass"
                            />
                            <p v-if="createForm.errors.sort_order" class="text-sm text-rose-400">
                                {{ createForm.errors.sort_order }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-medium text-zinc-300">
                            <Link2 class="h-4 w-4 text-amber-400" />
                            URL del botón <span class="text-zinc-500">(opcional)</span>
                        </label>
                        <input
                            v-model="createForm.cta_url"
                            type="text"
                            placeholder="https://..."
                            :class="inputClass"
                        />
                        <p v-if="createForm.errors.cta_url" class="text-sm text-rose-400">
                            {{ createForm.errors.cta_url }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-medium text-zinc-300">Imagen *</label>
                        <div class="rounded-3xl border border-dashed border-zinc-700 bg-zinc-900/70 p-3 transition duration-300 hover:border-amber-400/40 hover:bg-zinc-900">
                            <ImageUploader @selected="createForm.image = $event" />
                        </div>
                        <p v-if="createForm.errors.image" class="text-sm text-rose-400">
                            {{ createForm.errors.image }}
                        </p>
                    </div>

                    <label
                        class="flex cursor-pointer items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-900/80 px-4 py-4 transition duration-300 hover:border-amber-400/30 hover:bg-zinc-900"
                    >
                        <div class="flex items-center gap-3">
                            <div
                                class="rounded-2xl p-2.5 transition duration-300"
                                :class="createForm.is_active ? 'bg-emerald-500/15 text-emerald-400' : 'bg-zinc-800 text-zinc-500'"
                            >
                                <component :is="createForm.is_active ? Eye : EyeOff" class="h-4 w-4" />
                            </div>

                            <div>
                                <p class="text-sm font-medium text-zinc-100">Estado del slide</p>
                                <p class="text-xs text-zinc-500">
                                    {{ createForm.is_active ? 'Visible al público' : 'Oculto temporalmente' }}
                                </p>
                            </div>
                        </div>

                        <input
                            v-model="createForm.is_active"
                            type="checkbox"
                            class="h-5 w-5 rounded border-zinc-600 bg-zinc-800 text-amber-400 focus:ring-amber-400"
                        />
                    </label>

                    <button
                        type="submit"
                        :disabled="createForm.processing"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-amber-400 px-5 py-3.5 font-semibold text-zinc-950 shadow-[0_10px_25px_rgba(245,158,11,.18)] transition duration-300 hover:-translate-y-0.5 hover:bg-amber-300 hover:shadow-[0_12px_30px_rgba(245,158,11,.25)] disabled:cursor-not-allowed disabled:opacity-60"
                    >
                        <LoaderCircle v-if="createForm.processing" class="h-4 w-4 animate-spin" />
                        <BadgePlus v-else class="h-4 w-4" />
                        {{ createForm.processing ? 'Guardando...' : 'Guardar slide' }}
                    </button>
                </div>
            </form>

            <div v-if="hasSlides" class="grid gap-5 md:grid-cols-2 2xl:grid-cols-3">
                <div
                    v-for="slide in localSlides"
                    :key="slide.id"
                    :class="cardClass"
                >
                    <div class="relative overflow-hidden">
                        <img
                            v-if="slide.image_url"
                            :src="slide.image_url"
                            :alt="slide.title || 'Slide'"
                            class="h-60 w-full object-cover transition duration-500 group-hover:scale-[1.04]"
                        />

                        <div
                            v-else
                            class="flex h-60 items-center justify-center bg-gradient-to-br from-zinc-900 to-zinc-800 text-zinc-600"
                        >
                            <ImagePlus class="h-10 w-10" />
                        </div>

                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>

                        <div class="absolute left-4 top-4">
                            <span
                                class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold shadow-sm backdrop-blur-sm"
                                :class="slide.is_active
                                    ? 'border-emerald-400/20 bg-emerald-500/15 text-emerald-300'
                                    : 'border-zinc-600 bg-zinc-900/70 text-zinc-300'"
                            >
                                {{ slide.is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>

                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="line-clamp-1 text-lg font-semibold text-white">
                                {{ slide.title || 'Sin título' }}
                            </h3>
                            <p class="mt-1 line-clamp-2 text-sm text-zinc-300">
                                {{ slide.subtitle || 'Sin subtítulo capturado.' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-4 p-4 sm:p-5">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-300">Título *</label>
                            <input v-model="slide.title" type="text" :class="inputClass" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-300">
                                Subtítulo <span class="text-zinc-500">(opcional)</span>
                            </label>
                            <textarea v-model="slide.subtitle" rows="3" :class="textareaClass" />
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-medium text-zinc-300">
                                    Texto botón <span class="text-zinc-500">(opcional)</span>
                                </label>
                                <input v-model="slide.cta_text" type="text" :class="inputClass" />
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-medium text-zinc-300">
                                    Orden <span class="text-zinc-500">(opcional)</span>
                                </label>
                                <input v-model="slide.sort_order" type="number" min="0" :class="inputClass" />
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-300">
                                URL botón <span class="text-zinc-500">(opcional)</span>
                            </label>
                            <input v-model="slide.cta_url" type="text" :class="inputClass" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-300">
                                Cambiar imagen <span class="text-zinc-500">(opcional)</span>
                            </label>
                            <div class="rounded-3xl border border-dashed border-zinc-700 bg-zinc-900/70 p-3 transition duration-300 hover:border-amber-400/40 hover:bg-zinc-900">
                                <ImageUploader :preview="slide.image_url || undefined" @selected="slide.image = $event" />
                            </div>
                        </div>

                        <label
                            class="flex cursor-pointer items-center justify-between rounded-2xl border border-zinc-800 bg-zinc-900/80 px-4 py-4 transition duration-300 hover:border-amber-400/30 hover:bg-zinc-900"
                        >
                            <div class="flex items-center gap-3">
                                <div
                                    class="rounded-2xl p-2.5 transition duration-300"
                                    :class="slide.is_active ? 'bg-emerald-500/15 text-emerald-400' : 'bg-zinc-800 text-zinc-500'"
                                >
                                    <component :is="slide.is_active ? Eye : EyeOff" class="h-4 w-4" />
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-zinc-100">Estado</p>
                                    <p class="text-xs text-zinc-500">
                                        {{ slide.is_active ? 'Visible al público' : 'Oculto temporalmente' }}
                                    </p>
                                </div>
                            </div>

                            <input
                                v-model="slide.is_active"
                                type="checkbox"
                                class="h-5 w-5 rounded border-zinc-600 bg-zinc-800 text-amber-400 focus:ring-amber-400"
                            />
                        </label>

                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <button
                                @click="updateSlide(slide)"
                                type="button"
                                :disabled="updatingSlideId === slide.id"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-amber-400/20 bg-amber-400/10 px-4 py-3 font-semibold text-amber-300 transition duration-300 hover:-translate-y-0.5 hover:border-amber-400/40 hover:bg-amber-400/20 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                <LoaderCircle v-if="updatingSlideId === slide.id" class="h-4 w-4 animate-spin" />
                                <Pencil v-else class="h-4 w-4" />
                                {{ updatingSlideId === slide.id ? 'Actualizando...' : 'Actualizar' }}
                            </button>

                            <button
                                @click="destroySlide(slide.id)"
                                type="button"
                                :disabled="deletingSlideId === slide.id"
                                class="inline-flex items-center justify-center gap-2 rounded-2xl border border-rose-500/20 bg-rose-500/10 px-4 py-3 font-semibold text-rose-300 transition duration-300 hover:-translate-y-0.5 hover:border-rose-500/40 hover:bg-rose-500/20 disabled:cursor-not-allowed disabled:opacity-60"
                            >
                                <LoaderCircle v-if="deletingSlideId === slide.id" class="h-4 w-4 animate-spin" />
                                <Trash2 v-else class="h-4 w-4" />
                                {{ deletingSlideId === slide.id ? 'Eliminando...' : 'Eliminar' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div
                v-else
                :class="panelClass"
                class="flex min-h-[360px] flex-col items-center justify-center p-8 text-center"
            >
                <div class="rounded-full border border-amber-400/20 bg-amber-400/10 p-5 text-amber-400">
                    <ImagePlus class="h-9 w-9" />
                </div>

                <h3 class="mt-5 text-xl font-semibold text-white">Aún no hay slides</h3>
                <p class="mt-2 max-w-md text-sm leading-relaxed text-zinc-400">
                    Crea tu primer slide para comenzar a construir el hero principal del sitio con una apariencia más elegante y profesional.
                </p>
            </div>
        </div>
    </div>
</template>
