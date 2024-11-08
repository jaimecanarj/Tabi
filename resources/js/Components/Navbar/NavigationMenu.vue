<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Menu } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
import {
    Sheet,
    SheetContent,
    SheetHeader,
    SheetTitle,
    SheetTrigger,
} from "@/Components/ui/sheet";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
</script>

<template>
    <nav class="md:hidden">
        <!-- Vista móvil -->
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
        <!-- Vista estándar -->
    </nav>
    <nav class="items-center hidden md:flex">
        <Link href="/home">
            <Button
                variant="link"
                class="pr-0 font-semibold text-foreground hover:text-primary hover:no-underline"
            >
                <ApplicationLogo class="w-10 h-10" />
            </Button>
        </Link>
        <Link href="/kanjis">
            <Button
                variant="link"
                class="font-semibold text-foreground hover:text-primary hover:no-underline"
            >
                Kanjis
            </Button>
        </Link>
        <Link href="/radicales">
            <Button
                variant="link"
                class="font-semibold text-foreground hover:text-primary hover:no-underline"
            >
                Radicales
            </Button>
        </Link>
        <Link href="/stats">
            <Button
                variant="link"
                class="font-semibold text-foreground hover:text-primary hover:no-underline"
            >
                Estadísticas
            </Button>
        </Link>
    </nav>
</template>
