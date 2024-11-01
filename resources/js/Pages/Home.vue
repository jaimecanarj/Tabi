<script setup lang="ts">
import MainLayout from "@/Layouts/MainLayout.vue";
import { Head } from "@inertiajs/vue3";
import {
    Card,
    CardHeader,
    CardTitle,
    CardContent,
    CardFooter,
} from "@/Components/ui/card";
import Button from "@/Components/ui/button/Button.vue";
import { BookOpen, GraduationCap } from "lucide-vue-next";
</script>

<template>
    <Head title="Home" />
    <MainLayout />
    <main class="container mt-12">
        <section
            class="flex flex-col items-center space-y-4 md:space-x-4 md:space-y-0 md:flex-row"
        >
            <Card
                class="flex flex-col justify-between min-w-96 md:w-1/2 h-96 bg-muted"
            >
                <CardHeader>
                    <CardTitle class="text-4xl text-center">
                        <GraduationCap class="inline w-10 h-10 mr-2" />
                        Repasar
                    </CardTitle>
                </CardHeader>
                <CardContent>Como hago para memorizar todo eso.</CardContent>
                <CardFooter>
                    <Button class="w-full"> Empezar </Button>
                </CardFooter>
            </Card>
            <Card
                class="flex flex-col justify-between min-w-96 h-96 md:w-1/2 bg-secondary"
            >
                <CardHeader>
                    <CardTitle class="text-4xl text-center">
                        <BookOpen class="inline w-8 h-8 mr-2" />
                        Aprender
                    </CardTitle>
                </CardHeader>
                <CardContent>Tocará empezar por algún lado.</CardContent>
                <CardFooter>
                    <Button class="w-full" variant="default">Empezar</Button>
                </CardFooter>
            </Card>
        </section>
        <section>Últimos kanjis estudiados 人</section>
        <section>
            Fechas de cuando tienes kanjis para repasar, posible gráfica
        </section>
    </main>
</template>
