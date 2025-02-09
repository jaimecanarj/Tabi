<script setup lang="ts">
import { DateTime } from "luxon";
import { CircleCheck, CircleX } from "lucide-vue-next";
import { Study } from "@/types";
import { ScrollArea } from "@/Components/ui/scroll-area";

defineProps<{ studies: Study[] }>();
</script>

<template>
    <div class="mt-3 lg:mr-24">
        <h2 class="mb-3 text-2xl font-semibold lg:px-3">Histórico</h2>
        <ScrollArea class="w-48 lg:px-3" height-class="max-h-60" type="auto">
            <div
                :class="[{ 'mb-6': index < studies.length - 1 }, 'relative']"
                v-for="(study, index) of studies"
            >
                <span
                    v-if="index < studies.length - 1"
                    class="absolute left-[0.7rem] top-8 h-2/3 w-0.5 bg-muted"
                ></span>
                <p>
                    <CircleCheck
                        v-if="study.answer"
                        class="inline text-emerald-500"
                    />
                    <CircleX v-else class="inline text-rose-500" />
                    {{
                        DateTime.fromSQL(study.date, { zone: "utc" })
                            .toLocal()
                            .toFormat("dd MMM yyyy HH:mm")
                    }}
                </p>
            </div>
        </ScrollArea>
    </div>
</template>
