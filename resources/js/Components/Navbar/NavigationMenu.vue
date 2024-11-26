<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Menu } from "lucide-vue-next";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Button } from "@/Components/ui/button";
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet";
</script>

<template>
    <!-- Vista móvil -->
    <nav class="md:hidden" aria-label="Menu">
        <Sheet>
            <SheetTrigger as-child>
                <Button variant="ghost">
                    <Menu />
                </Button>
            </SheetTrigger>
            <SheetContent side="left" class="w-[200px]">
                <SheetHeader class="mt-4 sm:text-center">
                    <Link href="/inicio">
                        <SheetTitle
                            class="flex items-center hover:text-primary"
                        >
                            <ApplicationLogo class="h-12 w-10" />
                            <p class="ml-2 font-logo text-3xl">Tabi</p>
                        </SheetTitle>
                    </Link>
                </SheetHeader>
                <div class="mt-4 flex flex-col">
                    <Link href="/kanjis">
                        <Button
                            variant="link"
                            class="justify-start text-xl text-foreground hover:text-primary hover:no-underline"
                        >
                            Kanjis
                        </Button>
                    </Link>
                    <Link href="/radicales">
                        <Button
                            variant="link"
                            class="justify-start text-xl text-foreground hover:text-primary hover:no-underline"
                        >
                            Radicales
                        </Button>
                    </Link>
                    <Link href="/progreso">
                        <Button
                            variant="link"
                            class="justify-start text-xl text-foreground hover:text-primary hover:no-underline"
                        >
                            Tu progreso
                        </Button>
                    </Link>
                </div>
            </SheetContent>
        </Sheet>
    </nav>
    <!-- Vista estándar -->
    <nav class="hidden items-center md:flex">
        <Link href="/kanjis">
            <Button
                variant="link"
                class="mx-2 border-b-4 border-transparent px-0 text-xl text-foreground hover:text-primary hover:no-underline"
                :class="{
                    'border-primary': /^\/kanjis(\/.*)?$/.test($page.url),
                }"
            >
                Kanjis
            </Button>
        </Link>
        <Link href="/radicales">
            <Button
                variant="link"
                class="mx-2 border-b-4 border-transparent px-0 text-xl text-foreground hover:text-primary hover:no-underline"
                :class="{
                    'border-primary': /^\/radicales(\/.*)?$/.test($page.url),
                }"
            >
                Radicales
            </Button>
        </Link>
        <Link href="/progreso">
            <Button
                variant="link"
                class="mx-2 border-b-4 border-transparent px-0 text-xl text-foreground hover:text-primary hover:no-underline"
                :class="{ 'border-primary': $page.url == '/progreso' }"
            >
                Tu progreso
            </Button>
        </Link>
    </nav>
</template>
