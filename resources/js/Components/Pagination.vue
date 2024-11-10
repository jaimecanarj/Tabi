<script setup lang="ts">
import { ref, watch } from "vue";
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

const props = defineProps<{
    total: number;
    current_page: number;
    per_page: number;
}>();
defineEmits(["update:page"]);

let page = ref(props.current_page);
</script>

<template>
    <Pagination
        v-slot="{ page }"
        :total="total"
        :sibling-count="2"
        :default-page="current_page"
        :items-per-page="per_page"
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
                        class="w-10 h-10 p-0"
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
