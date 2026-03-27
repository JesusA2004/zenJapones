<script setup lang="ts">
import { computed, ref } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()
const isActive = (href: string) => page.url === href

const mobileOpen = ref(false)

const navItemsLeft = computed(() => [
    { label: 'Nosotros', href: '/' },
    { label: 'Sucursales', href: '/sucursales' },
])

const navItemsRight = computed(() => [
    { label: 'Menú', href: '/menu' },
    { label: 'Eventos', href: '/eventos' },
])

const billingUrl = 'https://factura-zugacloud.zugatech.com/?Cliente=ZEN'
</script>

<template>
    <header class="absolute inset-x-0 top-0 z-50">
        <!-- capa suave para distinguir sobre la imagen -->
        <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/20 to-transparent"></div>

        <!-- DESKTOP / TABLET -->
        <div class="relative hidden lg:block">
            <div class="mx-auto max-w-[1920px] px-8 pt-10 xl:px-14 2xl:px-20">
                <div class="grid grid-cols-[1fr_auto_1fr] items-start gap-8 xl:gap-12">
                    <!-- izquierda -->
                    <div class="flex min-w-0 items-center justify-evenly gap-8 xl:gap-14 2xl:gap-20">
                        <Link
                            href="/"
                            class="whitespace-nowrap text-[clamp(1rem,1.1vw,1.35rem)] font-semibold tracking-[0.03em] transition"
                            :class="isActive('/') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Nosotros
                        </Link>

                        <Link
                            href="/sucursales"
                            class="whitespace-nowrap text-[clamp(1rem,1.1vw,1.35rem)] font-semibold tracking-[0.03em] transition"
                            :class="isActive('/sucursales') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Sucursales
                        </Link>
                    </div>

                    <!-- centro -->
                    <Link href="/" class="flex shrink-0 items-center justify-center">
                        <div class="flex min-w-[190px] flex-col items-center xl:min-w-[220px]">
                            <img
                                src="/favicon.png"
                                alt="Zen Japonés"
                                class="h-14 w-14 object-contain xl:h-16 xl:w-16"
                            />
                            <span
                                class="mt-2 whitespace-nowrap text-[clamp(1.6rem,1.7vw,2.2rem)] font-semibold leading-none tracking-[0.16em] text-white"
                                style="font-family: 'Japanese3017', sans-serif !important;"
                            >
                                ZEN JAPONES
                            </span>
                        </div>
                    </Link>

                    <!-- derecha -->
                    <div class="flex min-w-0 items-center justify-evenly gap-8 xl:gap-14 2xl:gap-20">
                        <Link
                            href="/menu"
                            class="whitespace-nowrap text-[clamp(1rem,1.1vw,1.35rem)] font-semibold tracking-[0.03em] transition"
                            :class="isActive('/menu') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Menú
                        </Link>

                        <Link
                            href="/eventos"
                            class="whitespace-nowrap text-[clamp(1rem,1.1vw,1.35rem)] font-semibold tracking-[0.03em] transition"
                            :class="isActive('/eventos') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Eventos
                        </Link>

                        <a
                            :href="billingUrl"
                            target="_blank"
                            rel="noopener"
                            class="whitespace-nowrap text-[clamp(1rem,1.1vw,1.35rem)] font-semibold tracking-[0.03em] text-white transition hover:text-amber-400"
                        >
                            Facturación
                        </a>
                    </div>
                </div>

                <!-- línea -->
                <div class="-mt-6 grid grid-cols-[1fr_auto_1fr] items-center gap-3 xl:gap-4">
                    <div class="h-px bg-white/80"></div>
                    <div class="w-[190px] xl:w-[220px]"></div>
                    <div class="h-px bg-white/80"></div>
                </div>
            </div>
        </div>

        <!-- MOBILE / TABLET CHICA -->
        <div class="relative lg:hidden">
            <div class="mx-auto flex max-w-[1920px] items-center justify-between px-4 py-3 sm:px-6">
                <Link href="/" class="flex min-w-0 items-center gap-3">
                    <img
                        src="/favicon.png"
                        alt="Zen Japonés"
                        class="h-11 w-11 object-contain sm:h-12 sm:w-12"
                    />
                    <span
                        class="truncate text-[clamp(1rem,4vw,1.35rem)] font-semibold tracking-[0.12em] text-white"
                        style="font-family: 'Japanese3017', sans-serif !important;"
                    >
                        ZEN JAPONES
                    </span>
                </Link>

                <button
                    type="button"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-md border border-white/20 bg-black/20 text-white backdrop-blur-sm"
                    @click="mobileOpen = !mobileOpen"
                    aria-label="Abrir menú"
                >
                    <svg
                        v-if="!mobileOpen"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>

                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-4 sm:px-6">
                <div class="h-px bg-white/75"></div>
            </div>

            <transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0 -translate-y-2"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-2"
            >
                <div
                    v-if="mobileOpen"
                    class="mx-4 mt-3 rounded-xl border border-white/10 bg-black/80 p-4 backdrop-blur-md sm:mx-6"
                >
                    <nav class="flex flex-col gap-3">
                        <Link
                            v-for="item in navItemsLeft"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-md px-3 py-2 text-base font-semibold transition"
                            :class="isActive(item.href) ? 'bg-white/10 text-amber-400' : 'text-white hover:bg-white/10 hover:text-amber-400'"
                            @click="mobileOpen = false"
                        >
                            {{ item.label }}
                        </Link>

                        <Link
                            v-for="item in navItemsRight"
                            :key="item.href"
                            :href="item.href"
                            class="rounded-md px-3 py-2 text-base font-semibold transition"
                            :class="isActive(item.href) ? 'bg-white/10 text-amber-400' : 'text-white hover:bg-white/10 hover:text-amber-400'"
                            @click="mobileOpen = false"
                        >
                            {{ item.label }}
                        </Link>

                        <a
                            :href="billingUrl"
                            target="_blank"
                            rel="noopener"
                            class="rounded-md px-3 py-2 text-base font-semibold text-white transition hover:bg-white/10 hover:text-amber-400"
                            @click="mobileOpen = false"
                        >
                            Facturación
                        </a>
                    </nav>
                </div>
            </transition>
        </div>
    </header>
</template>
