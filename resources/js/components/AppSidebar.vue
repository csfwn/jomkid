<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    BadgeDollarSign,
    BookOpen,
    LayoutDashboard,
    ShieldCheck,
    Users,
} from '@lucide/vue';
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
import type { NavItem } from '@/types';
import type { User } from '@/types/auth';

const user = usePage().props.auth.user as User;
const mainNavItems: NavItem[] = [
    { title: 'Dashboard', href: '/dashboard', icon: LayoutDashboard },
    { title: 'Profil anak', href: '/children', icon: Users },
    { title: 'Belajar', href: '/learn', icon: BookOpen },
];

if (user.role === 'affiliate' || user.role === 'admin') {
    mainNavItems.push({
        title: 'Affiliate',
        href: '/affiliate',
        icon: BadgeDollarSign,
    });
}

if (user.role === 'admin') {
    mainNavItems.push({ title: 'Admin', href: '/admin', icon: ShieldCheck });
}
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu
                ><SidebarMenuItem
                    ><SidebarMenuButton size="lg" as-child
                        ><Link href="/dashboard"
                            ><AppLogo /></Link></SidebarMenuButton></SidebarMenuItem
            ></SidebarMenu>
        </SidebarHeader>
        <SidebarContent><NavMain :items="mainNavItems" /></SidebarContent>
        <SidebarFooter><NavUser /></SidebarFooter>
    </Sidebar>
    <slot />
</template>
