<script setup lang="ts">
import { computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";
import { DateTime } from "luxon";
import {
    User as UserIcon,
    Calendar,
    CalendarClock,
    BookMarked,
    SquareSigma,
} from "lucide-vue-next";
import { Study, Kanji, User } from "@/types";
import { kanjiLevels } from "@/lib/utils";
import MainLayout from "@/Layouts/MainLayout.vue";

const props = defineProps<{
    user: User;
    studyCount: number;
    studys: (Study & { kanji: Kanji })[];
}>();

const getKanjiLevel = (time: number) => {
    return kanjiLevels.find((levelData) => {
        return time / 24 < levelData.threshold;
    })!;
};

const studysWithLevel = computed(() => {
    return props.studys.map((study) => {
        return {
            id: study.kanji_id,
            literal: study.kanji.literal,
            meaning: study.kanji.meaning,
            level: getKanjiLevel(study.time),
        };
    });
});
</script>

<template>
    <Head title="Usuario" />
    <MainLayout />
    <main class="container mt-12">
        <div
            class="mb-6 flex flex-col space-y-8 rounded-md bg-card p-6 shadow-xl md:mb-0 md:flex-row md:space-x-10 md:space-y-0 lg:space-x-20"
        >
            <!-- Foto de perfil -->
            <div
                :class="[
                    { 'bg-gradient-primary-to-alt': !user.avatar },
                    'flex h-80 basis-2/5 items-center justify-center rounded-lg xl:basis-1/3',
                ]"
            >
                <img
                    v-if="user.avatar"
                    :src="`/storage/${user.avatar}`"
                    alt="avatar"
                    class="h-80 rounded-lg object-contain"
                />
                <UserIcon v-else :size="200" class="text-light" />
            </div>
            <!-- Información -->
            <div class="basis-3/5 xl:basis-2/3">
                <!-- Nombre -->
                <h1 class="mb-3 text-6xl font-semibold first-letter:capitalize">
                    {{ user.name }}
                </h1>
                <div
                    class="mt-10 flex flex-col sm:flex-row sm:items-center sm:gap-2 md:mt-20"
                >
                    <p class="flex items-center gap-1 lg:text-lg">
                        <Calendar strokeWidth="1.25" />Fecha de registro:
                    </p>
                    <p
                        class="mb-2 ml-8 text-lg font-semibold sm:m-0 sm:ml-0 lg:text-xl"
                    >
                        {{
                            DateTime.fromISO(user.created_at)
                                .setLocale("es")
                                .toFormat("d 'de' MMMM, yyyy")
                        }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <p class="flex items-center gap-1 lg:text-lg">
                        <BookMarked strokeWidth="1.25" />Índice:
                    </p>
                    <p
                        class="mb-2 ml-8 text-lg font-semibold capitalize sm:m-0 lg:text-xl"
                    >
                        {{ user.index }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <p class="flex items-center gap-1 lg:text-lg">
                        <SquareSigma strokeWidth="1.25" />Total estudiados:
                    </p>
                    <p
                        class="mb-2 ml-8 text-lg font-semibold sm:m-0 lg:text-xl"
                    >
                        {{ studyCount }} kanji{{ studyCount > 1 ? "s" : "" }}
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center sm:gap-2">
                    <p class="flex items-center gap-1 lg:text-lg">
                        <CalendarClock strokeWidth="1.25" />Último repaso:
                    </p>
                    <p
                        v-if="studyCount > 0"
                        class="mb-2 ml-8 text-lg font-semibold sm:m-0 lg:text-xl"
                    >
                        {{
                            DateTime.fromSQL(studys[0].date)
                                .setLocale("es")
                                .toFormat("d 'de' MMMM, yyyy")
                        }}
                    </p>
                    <p
                        v-else
                        class="mb-2 ml-8 text-lg font-semibold sm:m-0 lg:text-xl"
                    >
                        Sin estudios
                    </p>
                </div>
            </div>
        </div>
        <h2 class="mb-5 mt-8 text-5xl font-semibold">Últimos repasos</h2>
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
            <div
                class="flex flex-col items-center gap-2"
                v-for="study of studysWithLevel"
            >
                <Link :href="`/kanjis/${study.id}`">
                    <h3
                        class="bg-gradient-secondary w-28 rounded-md p-3 text-center text-6xl font-semibold"
                    >
                        {{ study.literal }}
                    </h3>
                </Link>
                <h4
                    class="w-32 text-center text-xl font-semibold first-letter:capitalize"
                >
                    {{ study.meaning }}
                </h4>
                <div class="flex items-center gap-1">
                    <component
                        :is="study.level.icon"
                        :size="24"
                        :class="[
                            study.level.bgColor,
                            'rounded-md p-1 text-light',
                        ]"
                    />
                    {{ study.level.name }}
                </div>
            </div>
        </div>
    </main>
</template>
