<script setup lang="ts">
    import Navbar from '@/components/Public/Navbar.vue'
    import Footer from '@/components/Public/Footer.vue'

    interface NavItem {
        label: string
        href: string
    }

    const navItems: NavItem[] = [
        { label: 'Nosotros', href: '/' },
        { label: 'Sucursales', href: '/sucursales' },
        { label: 'Menú', href: '/menu' },
        { label: 'Eventos', href: '/eventos' },
        { label: 'Facturación', href: '/facturacion' },
    ]
</script>

<template>
    <div class="min-h-screen bg-black text-white">
        <Navbar :items="navItems" />
        <main>
            <slot />
        </main>
        <Footer />
    </div>
</template>
