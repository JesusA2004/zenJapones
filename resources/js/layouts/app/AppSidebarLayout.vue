<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import AppShell from '@/components/AppShell.vue';
import AppSidebar from '@/components/AppSidebar.vue';
import AppSidebarHeader from '@/components/AppSidebarHeader.vue';
import type { BreadcrumbItem } from '@/types';

type Props = {
    breadcrumbs?: BreadcrumbItem[];
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell variant="sidebar">
        <AppSidebar />

        <AppContent
            variant="sidebar"
            class="min-h-screen overflow-x-hidden bg-zinc-950 text-zinc-100"
        >
            <div class="border-b border-white/5 bg-zinc-950">
                <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            </div>

            <div class="bg-zinc-950">
                <slot />
            </div>
        </AppContent>
    </AppShell>
</template>
