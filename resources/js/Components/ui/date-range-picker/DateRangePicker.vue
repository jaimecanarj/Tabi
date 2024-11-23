<script setup lang="ts">
import type { DateRange } from "radix-vue";
import { Button } from "@/Components/ui/button";

import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "@/Components/ui/popover";
import { RangeCalendar } from "@/Components/ui/range-calendar";
import { cn } from "@/lib/utils";
import {
    CalendarDate,
    DateFormatter,
    getLocalTimeZone,
} from "@internationalized/date";
import { Calendar as CalendarIcon } from "lucide-vue-next";
import { type Ref, ref } from "vue";

const df = new DateFormatter("es-ES", {
    dateStyle: "medium",
});

const value = ref({
    start: new CalendarDate(2024, 12, 1),
    end: new CalendarDate(2024, 12, 1).add({ days: 20 }),
}) as Ref<DateRange>;
</script>

<template>
    <Popover>
        <PopoverTrigger as-child>
            <Button
                variant="outline"
                :class="
                    cn(
                        'w-[280px] justify-center text-left text-lg font-normal',
                        !value && 'text-muted-foreground',
                    )
                "
            >
                <CalendarIcon class="mr-2 h-6 w-6" />
                <template v-if="value.start">
                    <template v-if="value.end">
                        {{ df.format(value.start.toDate(getLocalTimeZone())) }}
                        - {{ df.format(value.end.toDate(getLocalTimeZone())) }}
                    </template>

                    <template v-else>
                        {{ df.format(value.start.toDate(getLocalTimeZone())) }}
                    </template>
                </template>
                <template v-else> Selecciona una fecha </template>
            </Button>
        </PopoverTrigger>
        <PopoverContent class="w-auto p-0">
            <RangeCalendar
                v-model="value"
                :fixed-weeks="true"
                locale="es"
                initial-focus
                :number-of-months="2"
                @update:start-value="(startDate) => (value.start = startDate)"
            />
        </PopoverContent>
    </Popover>
</template>
