<script setup lang="ts">
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from "@/Components/ui/navigation-menu";
import Button from "@/Components/ui/button/Button.vue";
import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet";
import { Link } from "@inertiajs/vue3";
import { Menu } from "lucide-vue-next";
</script>

<template>
    <nav>
        <NavigationMenu>
            <!-- Vista móvil -->
            <NavigationMenuList class="md:hidden">
                <NavigationMenuItem>
                    <Sheet>
                        <SheetTrigger as-child>
                            <Button variant="ghost">
                                <Menu />
                            </Button>
                        </SheetTrigger>
                        <SheetContent side="left" class="w-[200px]">
                            <SheetHeader class="mt-4 sm:text-center">
                                <SheetTitle>Logo</SheetTitle>
                            </SheetHeader>
                            <div class="flex flex-col">
                                <Button
                                    variant="link"
                                    class="justify-start text-foreground hover:text-primary hover:no-underline"
                                >
                                    Kanjis
                                </Button>
                            </div>
                        </SheetContent>
                    </Sheet>
                </NavigationMenuItem>
            </NavigationMenuList>
            <!-- Vista estándar -->
            <NavigationMenuList class="hidden md:flex">
                <NavigationMenuItem>
                    <NavigationMenuLink
                        :class="navigationMenuTriggerStyle()"
                        asChild
                    >
                        <Link href="/home">Inicio</Link>
                    </NavigationMenuLink>
                </NavigationMenuItem>
                <NavigationMenuItem>
                    <NavigationMenuLink
                        :class="navigationMenuTriggerStyle()"
                        asChild
                        ><Link href="/kanjis">Kanjis</Link></NavigationMenuLink
                    >
                </NavigationMenuItem>
                <NavigationMenuItem>
                    <NavigationMenuLink
                        :class="navigationMenuTriggerStyle()"
                        asChild
                    >
                        <Link href="/stats">Estadísticas</Link>
                    </NavigationMenuLink>
                </NavigationMenuItem>
            </NavigationMenuList>
        </NavigationMenu>
    </nav>
</template>
