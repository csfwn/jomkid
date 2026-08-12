<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import {
    BadgeDollarSign,
    BookOpen,
    Boxes,
    GraduationCap,
    LayoutDashboard,
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
const mainNavItems: NavItem[] = [];

if (user.role === 'admin') {
    mainNavItems.push(
        { title: 'Analitik', href: '/admin', icon: LayoutDashboard },
        { title: 'Senarai pengguna', href: '/admin/users', icon: Users },
        { title: 'Senarai pakej', href: '/admin/packages', icon: Boxes },
        {
            title: 'Senarai pelajar',
            href: '/admin/students',
            icon: GraduationCap,
        },
        {
            title: 'Senarai affiliate',
            href: '/admin/affiliates',
            icon: BadgeDollarSign,
        },
    );
} else {
    mainNavItems.push(
        { title: 'Dashboard', href: '/dashboard', icon: LayoutDashboard },
        { title: 'Profil anak', href: '/children', icon: Users },
        { title: 'Belajar', href: '/learn', icon: BookOpen },
    );
}

if (user.role === 'affiliate') {
    mainNavItems.push({
        title: 'Affiliate',
        href: '/affiliate',
        icon: BadgeDollarSign,
    });
}
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu
                ><SidebarMenuItem
                    ><SidebarMenuButton size="lg" as-child
                        ><Link
                            :href="
                                user.role === 'admin' ? '/admin' : '/dashboard'
                            "
                            ><AppLogo /></Link></SidebarMenuButton></SidebarMenuItem
            ></SidebarMenu>
        </SidebarHeader>
        <SidebarContent><NavMain :items="mainNavItems" /></SidebarContent>
        <SidebarFooter><NavUser /></SidebarFooter>
    </Sidebar>
    <slot />
</template>
