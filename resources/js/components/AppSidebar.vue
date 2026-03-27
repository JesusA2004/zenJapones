<script setup lang="ts">
import AppLogo from '@/components/AppLogo.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import {
    CalendarDays,
    FileText,
    Image,
    LayoutGrid,
    MapPin,
    Settings,
    Soup,
    Tags,
} from 'lucide-vue-next';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    { title: 'Dashboard', href: '/admin', icon: LayoutGrid },
    { title: 'Ajustes', href: '/admin/settings', icon: Settings },
    { title: 'Hero Slides', href: '/admin/hero-slides', icon: Image },
    { title: 'Secciones', href: '/admin/secciones', icon: FileText },
    { title: 'Sucursales', href: '/admin/sucursales', icon: MapPin },
    { title: 'Eventos', href: '/admin/eventos', icon: CalendarDays },
    { title: 'Categorías', href: '/admin/categorias-menu', icon: Tags },
    { title: 'Platillos', href: '/admin/menu-items', icon: Soup },
];
</script>

<template>
    <Sidebar
        collapsible="icon"
        variant="sidebar"
        class="border-r border-white/5 bg-zinc-950 text-zinc-100"
    >
        <SidebarHeader class="border-b border-white/5 bg-zinc-950">
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton
                        size="lg"
                        as-child
                        class="text-zinc-100 hover:bg-zinc-900 hover:text-white"
                    >
                        <Link href="/admin">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent class="bg-zinc-950">
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter class="border-t border-white/5 bg-zinc-950">
            <NavUser />
        </SidebarFooter>
    </Sidebar>

    <slot />
</template>
