<script setup lang="ts">
import { LogOut, Search, Settings, User } from "lucide-vue-next";
import { Avatar, AvatarImage, AvatarFallback } from "@/Components/ui/avatar";
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from "@/Components/ui/dropdown-menu";
import Input from "@/Components/ui/input/Input.vue";
import NavigationMenu from "@/Components/Navbar/NavigationMenu.vue";
import ToggleDarkMode from "@/Components/Navbar/ToggleDarkMode.vue";
import { Link } from "@inertiajs/vue3";
import Button from "@/Components/ui/button/Button.vue";
</script>

<template>
    <header class="border-b border-border">
        <div class="container flex items-center justify-between h-14">
            <NavigationMenu />
            <div class="flex items-center gap-x-2">
                <div class="relative items-center w-full max-w-sm">
                    <Input
                        id="search"
                        type="text"
                        placeholder="Buscar..."
                        class="h-8 pl-10 bg-muted"
                    />
                    <span
                        class="absolute inset-y-0 flex items-center justify-center px-2 start-0"
                    >
                        <Search class="size-6 text-muted-foreground" />
                    </span>
                </div>
                <ToggleDarkMode />
                <DropdownMenu v-if="$page.props.auth.user">
                    <DropdownMenuTrigger as-child>
                        <Avatar class="mx-1 cursor-pointer h-9 w-9">
                            <AvatarImage
                                src="https://avatars.cloudflare.steamstatic.com/e015a46d3104fa6951dd5a6cc3ee94311c710b1a_full.jpg"
                            />
                            <AvatarFallback>KQ</AvatarFallback>
                        </Avatar>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-40">
                        <DropdownMenuItem>
                            <User class="w-5 h-5 mr-1" /> Mi cuenta
                        </DropdownMenuItem>
                        <DropdownMenuItem>
                            <Settings class="w-5 h-5 mr-1" /> Opciones
                        </DropdownMenuItem>
                        <DropdownMenuSeparator />
                        <DropdownMenuItem>
                            <LogOut class="w-5 h-5 mr-1" />
                            <Link href="/logout" method="post"
                                >Cerrar sesión</Link
                            >
                        </DropdownMenuItem>
                    </DropdownMenuContent>
                </DropdownMenu>
                <Button variant="ghost" v-else
                    ><Link href="/login">Iniciar sesión</Link></Button
                >
            </div>
        </div>
    </header>
</template>
