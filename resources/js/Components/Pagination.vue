<script setup lang="ts">
import { onMounted, onUnmounted, ref } from "vue";
import { breakpointsTailwind, useBreakpoints } from "@vueuse/core";
import { Button } from "@/Components/ui/button";
import {
    Pagination,
    PaginationEllipsis,
    PaginationFirst,
    PaginationLast,
    PaginationList,
    PaginationListItem,
    PaginationNext,
    PaginationPrev,
} from "@/Components/ui/pagination";

const breakpoints = useBreakpoints(breakpointsTailwind);

const props = defineProps<{
    total: number;
    currentPage: number;
    perPage: number;
}>();
defineEmits(["update:page"]);

let page = ref(props.currentPage);
const siblings = ref(breakpoints.isSmaller("sm"));

onMounted(() => {
    window.addEventListener("resize", setSiblings);
});

onUnmounted(() => {
    window.removeEventListener("resize", setSiblings);
});

//Definir números en paginación en base al tamaño de pantalla
const setSiblings = () => {
    siblings.value = breakpoints.isSmaller("sm");
};
</script>

<template>
    <Pagination
        v-slot="{ page }"
        :total="total"
        :sibling-count="siblings ? 1 : 2"
        :default-page="currentPage"
        :items-per-page="perPage"
        v-model:page="page"
        @update:page="$emit('update:page', page)"
    >
        <PaginationList v-slot="{ items }" class="flex items-center gap-1">
            <PaginationFirst />
            <PaginationPrev />

            <template v-for="(item, index) in items">
                <PaginationListItem
                    v-if="item.type === 'page'"
                    :key="index"
                    :value="item.value"
                    as-child
                >
                    <Button
                        class="h-10 w-10 p-0"
                        :variant="item.value === page ? 'default' : 'outline'"
                    >
                        {{ item.value }}
                    </Button>
                </PaginationListItem>
                <PaginationEllipsis v-else :key="item.type" :index="index" />
            </template>

            <PaginationNext />
            <PaginationLast />
        </PaginationList>
    </Pagination>
</template>
