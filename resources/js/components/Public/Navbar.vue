<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const isActive = (href: string) => page.url === href
</script>

<template>
    <header class="sticky top-0 z-50 border-b border-white/10 bg-black/85 backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 md:px-6">
            <Link href="/" class="text-lg font-semibold tracking-[0.18em] text-white md:hidden">
                ZEN JAPONÉS
            </Link>

            <div class="hidden flex-1 items-center justify-center md:flex">
                <div class="flex w-full max-w-7xl items-center justify-between">
                    <div class="flex items-center gap-10">
                        <Link
                            href="/"
                            class="text-sm font-medium transition"
                            :class="isActive('/') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Nosotros
                        </Link>

                        <Link
                            href="/sucursales"
                            class="text-sm font-medium transition"
                            :class="isActive('/sucursales') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Sucursales
                        </Link>
                    </div>

                    <Link href="/" class="mx-8 flex items-center justify-center">
                        <div class="flex flex-col items-center">
                            <div class="mb-2 flex h-12 w-12 items-center justify-center rounded-full bg-amber-400 text-black font-bold">
                                禅
                            </div>
                            <span class="text-xl font-semibold tracking-[0.18em] text-white">ZEN JAPONÉS</span>
                        </div>
                    </Link>

                    <div class="flex items-center gap-10">
                        <Link
                            href="/menu"
                            class="text-sm font-medium transition"
                            :class="isActive('/menu') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Menú
                        </Link>

                        <Link
                            href="/eventos"
                            class="text-sm font-medium transition"
                            :class="isActive('/eventos') ? 'text-amber-400' : 'text-white hover:text-amber-400'"
                        >
                            Eventos
                        </Link>

                        <a
                            href="https://factura-zugacloud.zugatech.com/?Cliente=ZEN"
                            target="_blank"
                            rel="noopener"
                            class="text-sm font-medium text-white transition hover:text-amber-400"
                        >
                            Facturación
                        </a>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-4 md:hidden">
                <Link href="/menu" class="text-sm text-white">Menú</Link>
                <Link href="/eventos" class="text-sm text-white">Eventos</Link>
            </div>
        </div>
    </header>
</template>
