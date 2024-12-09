<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { ChevronRight, Hash } from "lucide-vue-next";
import MainLayout from "@/Layouts/MainLayout.vue";
import { Button } from "@/Components/ui/button";
import { Badge } from "@/Components/ui/badge";
import { kanjiLevels } from "@/lib/utils";
</script>

<template>
    <Head title="Acerca de" />
    <MainLayout />
    <main class="container my-6">
        <h1 class="border-b-2 pb-5 text-5xl font-semibold sm:text-6xl">
            Acerca de
        </h1>
        <p class="ml-8 mt-4 text-xl">
            El objetivo de esta página web es ayudarte en tu estudio de los
            ideogramas kanji.
        </p>
        <!--Botón estudiar-->
        <div class="mt-12 flex flex-col justify-between gap-4 md:flex-row">
            <div>
                <h2 class="flex items-end gap-2 text-4xl font-semibold">
                    <Hash :size="36" />
                    ¿Cómo funciona?
                </h2>
                <p class="ml-8 mt-4 max-w-96 text-lg">
                    Cuando registres una cuenta, verás la opción de estudiar
                    disponible.<br class="mb-2" />Al pulsar en ella, podrás
                    empezar a estudiar los kanjis según el índice que hayas
                    escogido.
                </p>
            </div>
            <div
                class="ml-8 w-[296px] rounded-md bg-primary p-5 shadow-lg sm:w-[400px] md:ml-0"
            >
                <div class="flex justify-between">
                    <div class="ml-1 mt-4 flex flex-col">
                        <div
                            class="mb-3 flex items-end gap-2 text-2xl font-semibold text-light sm:text-3xl"
                        >
                            Estudiar
                        </div>
                    </div>
                    <div>
                        <img
                            src="
                        /assets/Viajero%20con%20pergamino.webp
                    "
                            alt="viajero"
                            class="w-32 sm:w-40"
                        />
                    </div>
                </div>
                <Button
                    variant="secondary"
                    class="mt-4 w-full bg-light text-xl text-primary shadow-md transition-all duration-300 hover:translate-x-[-4px] hover:translate-y-[-4px] hover:rounded-md hover:bg-light hover:shadow-[4px_4px_0px_black] active:translate-x-[0px] active:translate-y-[0px] active:rounded-2xl active:shadow-none"
                >
                    <p>Empezar a estudiar</p>
                    <ChevronRight :size="28" class="mt-1.5" />
                </Button>
            </div>
        </div>
        <!--Historia de un kanji-->
        <div class="mt-8 flex flex-col justify-between gap-4 md:flex-row">
            <div
                class="order-1 ml-8 flex min-w-80 gap-6 rounded-md bg-card p-5 md:order-none md:ml-0 md:flex-col lg:flex-row lg:gap-8"
            >
                <div>
                    <img
                        src="/assets/Tabi.svg"
                        alt="Tabi"
                        class="w-32 sm:w-40"
                    />
                    <div class="mt-4 flex flex-col gap-1 text-xl">
                        <p>
                            <span class="text-levels-educated">方</span>
                            Dirección
                        </p>
                        <p>
                            <span class="text-levels-proficient">𠂉</span> Arma
                        </p>
                        <p>
                            <span class="text-levels-master">氏</span> Apellido
                        </p>
                    </div>
                </div>
                <div class="max-w-52">
                    <h4 class="text-2xl font-semibold lg:mt-8">Historia</h4>
                    <p class="mt-4 text-lg">
                        Historia de este kanji usando las palabras direccion,
                        arma y apellido. Tienen que apuntar a viaje.
                    </p>
                </div>
            </div>
            <p class="ml-8 mt-4 max-w-[500px] text-lg">
                Al empezar el estudio, aparecerá el kanji a estudiar en grande,
                y abajo se nos mostrará los radicales que lo conforman.
                <br class="mb-2" />
                La manera de aprendizaje que se pretende es la creación de
                historias con el significado de los radicales que conforman al
                kanji. De esta manera se hace uso de la memoria imaginativa en
                lugar de la visual, basándonos únicamente en una imagen creada
                en nuestra cabeza.<br class="mb-2" />Los radicales usados se
                basan en los de la etimología tradicional, pero tanto su
                significado como su extensión han sido modificados para
                adaptarse mejor a nuestros objetivos.
            </p>
        </div>
        <!--Repaso-->
        <div
            class="mt-12 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h2 class="flex items-end gap-2 text-4xl font-semibold">
                    <Hash :size="36" />
                    Hora de repasar
                </h2>
                <p class="ml-8 mt-4 max-w-96 text-lg">
                    Cuando has terminado de estudiar, toca repasar lo aprendido.
                    Te aparecerán los kanjis estudiados en un orden aleatorio, y
                    tendrás que responder el significado de cada uno.
                </p>
                <p class="ml-8 mt-2 max-w-96 text-lg">
                    Si fallas, volverá a aparecerte a lo largo de la sesión.
                    Cuando los aciertes todos, terminará el repaso.
                </p>
                <p class="ml-8 mt-2 max-w-96 text-lg">
                    A medida que vayas acertando en las sesiones de repaso, el
                    tiempo entre sesión y sesión irá aumentando así como tu
                    nivel de conocimiento con cada kanji.
                </p>
            </div>
            <div class="ml-8 w-[296px] sm:w-[400px] md:ml-0">
                <div
                    class="h-48 rounded-t-md bg-gradient-primary-to-alt p-5 text-center text-9xl text-light"
                >
                    旅
                </div>
                <div class="rounded-b-md bg-card p-5 text-center text-xl">
                    Tu respuesta
                </div>
            </div>
        </div>
        <!--Uso diario-->
        <div
            class="mt-12 flex flex-col justify-between gap-4 md:flex-row md:items-center"
        >
            <div>
                <h2 class="flex items-end gap-2 text-4xl font-semibold">
                    <Hash :size="36" />
                    Uso diario
                </h2>
                <p class="ml-8 mt-4 max-w-96 text-lg">
                    Cuando te conectes, lo primero que tienes que hacer es
                    repasar los kanjis pendientes. Una vez terminado, toca
                    estudiar los kanjis diarios que te has marcado como
                    objetivo.
                </p>
                <p class="ml-8 mt-2 max-w-96 text-lg">
                    Al finalizar, puedes ver tu progreso, y como los kanjis
                    estudiados van subiendo de nivel. Si tienes alguna duda con
                    un kanji, puedes consultar su información, así como ver una
                    vista detallada de tu progreso con el mismo.
                </p>
            </div>
            <div class="ml-8 grid h-48 max-w-96 grid-cols-3 md:ml-0">
                <div
                    v-for="level of kanjiLevels"
                    :class="[
                        level.bgColor,
                        'flex flex-col items-center justify-center gap-1 p-5 font-semibold text-light',
                    ]"
                >
                    <p>{{ level.name }}</p>
                    <Component :is="level.icon" />
                </div>
            </div>
        </div>
        <div class="ml-8 mt-12">
            Proyecto realizado por Jaime Cañada Arjona, estudiante de 2º de DAW
            en el IES Trassierra
        </div>
    </main>
</template>
