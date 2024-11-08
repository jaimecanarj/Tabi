<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { LogIn, LogOut, Settings, User, UserPlus } from "lucide-vue-next";
import NavigationMenu from "@/Components/Navbar/NavigationMenu.vue";
import ToggleDarkMode from "@/Components/Navbar/ToggleDarkMode.vue";
import SearchNav from "@/Components/Navbar/SearchNav.vue";
import { Toaster } from "@/Components/ui/toast";
import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
</script>

<template>
    <Toaster />
    <header class="shadow-md">
        <div class="container flex items-center justify-between h-14">
            <NavigationMenu />
            <div class="flex items-center gap-x-1">
                <SearchNav />
                <ToggleDarkMode />
                <!-- Menú usuario -->
                <DropdownMenu :key="$page.props.auth?.user?.email">
                    <DropdownMenuTrigger as-child>
                        <!-- Avatar -->
                        <Avatar
                            :class="[
                                { 'bg-primary': $page.props.auth.user },
                                'mx-1 cursor-pointer h-9 w-9',
                            ]"
                        >
                            <AvatarImage
                                v-if="$page.props.auth.user?.avatar"
                                :src="`/storage/${$page.props.auth.user.avatar}`"
                            />
                            <AvatarFallback
                                :class="{
                                    'text-primary-foreground':
                                        $page.props.auth.user,
                                }"
                                ><User
                            /></AvatarFallback>
                        </Avatar>
                    </DropdownMenuTrigger>
                    <!-- Menú logueado -->
                    <DropdownMenuContent
                        align="end"
                        class="w-40"
                        v-if="$page.props.auth.user"
                    >
                        <DropdownMenuItem>
                            <User class="w-5 h-5 mr-1" /> Mi cuenta
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Settings class="w-5 h-5 mr-1" /> Opciones
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="w-full"
                        >
                            <DropdownMenuItem class="cursor-pointer">
                                <LogOut class="inline w-5 h-5 mr-1" />
                                Cerrar sesión
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuContent>
                    <!-- Menú desconectado -->
                    <DropdownMenuContent align="end" class="w-40" v-else>
                        <Link href="/login">
                            <DropdownMenuItem class="cursor-pointer">
                                <LogIn class="inline w-5 h-5 mr-1" />
                                Iniciar sesión
                            </DropdownMenuItem>
                        </Link>
                        <Link href="/register">
                            <DropdownMenuItem class="cursor-pointer">
                                <UserPlus class="inline w-5 h-5 mr-1" />
                                Registrarse
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </header>
</template>
