<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { useBreakpoints, breakpointsTailwind } from "@vueuse/core";
import { LogIn, LogOut, Settings, User, UserPlus, Info } from "lucide-vue-next";
import NavigationMenu from "@/Components/Navbar/NavigationMenu.vue";
import ToggleDarkMode from "@/Components/Navbar/ToggleDarkMode.vue";
import SearchNav from "@/Components/Navbar/SearchNav.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Toaster } from "@/Components/ui/toast";
import { Button } from "@/Components/ui/button";
import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";

const breakpoints = useBreakpoints(breakpointsTailwind);

const showLogo = breakpoints.greaterOrEqual("md");
</script>

<template>
    <Toaster />
    <header class="shadow-md">
        <div class="container flex h-14 items-center justify-between">
            <Link href="/inicio" v-if="showLogo">
                <Button
                    variant="link"
                    class="text-foreground hover:text-primary hover:no-underline"
                >
                    <ApplicationLogo class="h-10 w-10" />
                    <p class="ml-1 font-logo text-2xl">Tabi</p>
                </Button>
            </Link>
            <NavigationMenu />
            <div class="flex items-center gap-x-1">
                <SearchNav />
                <ToggleDarkMode />
                <Link href="/about">
                    <Button variant="ghost" size="icon"> <Info /> </Button>
                </Link>
                <!-- Menú usuario -->
                <DropdownMenu :key="$page.props.auth?.user?.email">
                    <DropdownMenuTrigger as-child>
                        <!-- Avatar -->
                        <Avatar
                            :class="[
                                { 'bg-primary': $page.props.auth.user },
                                'mx-1 h-9 w-9 cursor-pointer',
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
                        <Link :href="`/usuario/${$page.props.auth.user.id}`">
                            <DropdownMenuItem class="cursor-pointer">
                                <User class="mr-1 h-5 w-5" /> Mi cuenta
                            </DropdownMenuItem>
                        </Link>
                        <Link href="/opciones">
                            <DropdownMenuItem class="cursor-pointer">
                                <Settings class="mr-1 h-5 w-5" /> Opciones
                            </DropdownMenuItem>
                        </Link>
                        <DropdownMenuSeparator />
                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="w-full"
                        >
                            <DropdownMenuItem class="cursor-pointer">
                                <LogOut class="mr-1 inline h-5 w-5" />
                                Cerrar sesión
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuContent>
                    <!-- Menú desconectado -->
                    <DropdownMenuContent align="end" class="w-40" v-else>
                        <Link href="/login">
                            <DropdownMenuItem class="cursor-pointer">
                                <LogIn class="mr-1 inline h-5 w-5" />
                                Iniciar sesión
                            </DropdownMenuItem>
                        </Link>
                        <Link href="/register">
                            <DropdownMenuItem class="cursor-pointer">
                                <UserPlus class="mr-1 inline h-5 w-5" />
                                Registrarse
                            </DropdownMenuItem>
                        </Link>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </header>
</template>
