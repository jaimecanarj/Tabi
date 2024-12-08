<script setup lang="ts">
import moment from "moment/moment";
import { CircleCheck, CircleX } from "lucide-vue-next";
import { Estudio } from "@/lib/types";
import { momentLocale } from "@/lib/utils";
import { ScrollArea } from "@/Components/ui/scroll-area";

defineProps<{ estudios: Estudio[] }>();

momentLocale();
</script>

<template>
    <div class="mt-3 lg:mr-24">
        <h2 class="mb-3 text-2xl font-semibold lg:px-3">Histórico</h2>
        <ScrollArea class="w-48 lg:px-3" height-class="max-h-60" type="auto">
            <div
                :class="[{ 'mb-6': index < estudios.length - 1 }, 'relative']"
                v-for="(estudio, index) of estudios"
            >
                <span
                    v-if="index < estudios.length - 1"
                    class="absolute left-[0.7rem] top-8 h-2/3 w-0.5 bg-muted"
                ></span>
                <p>
                    <CircleCheck
                        v-if="estudio.respuesta"
                        class="inline text-emerald-500"
                    />
                    <CircleX v-else class="inline text-rose-500" />
                    {{
                        moment
                            .utc(estudio.fecha)
                            .local()
                            .format("DD MMM YYYY HH:mm")
                    }}
                </p>
            </div>
        </ScrollArea>
    </div>
</template>
