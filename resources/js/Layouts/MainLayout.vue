<script setup lang="ts">
import { LogIn, LogOut, Settings, User, UserPlus } from "lucide-vue-next";
import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import NavigationMenu from "@/Components/Navbar/NavigationMenu.vue";
import ToggleDarkMode from "@/Components/Navbar/ToggleDarkMode.vue";
import SearchNav from "@/Components/Navbar/SearchNav.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <header>
        <div class="container flex items-center justify-between h-14">
            <NavigationMenu />
            <div class="flex items-center gap-x-1">
                <SearchNav />
                <ToggleDarkMode />
                <DropdownMenu>
                    <DropdownMenuTrigger as-child>
                        <Avatar class="mx-1 cursor-pointer h-9 w-9">
                            <AvatarImage
                                src="https://avatars.cloudflare.steamstatic.com/e015a46d3104fa6951dd5a6cc3ee94311c710b1a_full.jpg"
                            />
                            <AvatarFallback><User /></AvatarFallback>
                        </Avatar>
                    </DropdownMenuTrigger>
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
                        <DropdownMenuItem class="cursor-pointer">
                            <Link href="/logout" method="post" as="button">
                                <LogOut class="inline w-5 h-5 mr-1" />
                                Cerrar sesión
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                    <DropdownMenuContent align="end" class="w-40" v-else>
                        <DropdownMenuItem class="cursor-pointer">
                            <Link href="/login" as="button">
                                <LogIn class="inline w-5 h-5 mr-1" />
                                Iniciar sesión
                            </Link>
                        </DropdownMenuItem>
                        <DropdownMenuItem class="cursor-pointer">
                            <Link href="/register" as="button">
                                <UserPlus class="inline w-5 h-5 mr-1" />
                                Registrarse
                            </Link>
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>
    </header>
</template>
