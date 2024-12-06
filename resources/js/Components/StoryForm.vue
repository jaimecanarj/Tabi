<script setup lang="ts">
import { onMounted } from "vue";
import axios from "axios";
import { useForm, usePage } from "@inertiajs/vue3";
import { Button } from "@/Components/ui/button";
import { Textarea } from "@/Components/ui/textarea";
import { useToast } from "@/Components/ui/toast";
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from "@/Components/ui/alert-dialog";

const page = usePage();
const { toast } = useToast();

const props = defineProps<{ kanji_id: number }>();
const emit = defineEmits(["close"]);

const form = useForm({
    id: null,
    historia: "",
    user_id: page.props.auth.user?.id,
    kanji_id: props.kanji_id,
});

const fetchHistoria = async () => {
    let historia = await axios.get(
        `/historia/${page.props.auth.user.id}/${props.kanji_id}`,
    );

    if (historia.data) {
        form.id = historia.data.id;
        form.historia = historia.data.historia;
    }
};

const submit = () => {
    form.post("/historia", {
        onSuccess: () => {
            toast({
                title: form.id ? "Historia actualizada" : "Historia creada",
            });
            emit("close");
            fetchHistoria();
        },
    });
};

const deleteStory = () => {
    form.delete("/historia", {
        onSuccess: () => {
            toast({
                title: "Historia borrada",
            });
            form.id = null;
            form.historia = "";
            emit("close");
        },
    });
};

onMounted(() => {
    fetchHistoria();
});
</script>

<template>
    <!-- Formulario -->
    <form id="submitStory" @submit.prevent="submit">
        <Textarea v-model="form.historia" class="min-h-32 bg-card" />
    </form>
    <!-- Error -->
    <p class="mt-2 text-sm text-red-600" v-show="form.errors.historia">
        {{ form.errors.historia }}
    </p>
    <!-- Botones -->
    <div class="mt-3 flex items-center justify-end gap-2">
        <!-- Borrar -->
        <AlertDialog v-if="form.id">
            <AlertDialogTrigger as-child>
                <div
                    class="ml-3 mr-auto cursor-pointer rounded-md border-2 border-transparent px-4 py-2 transition hover:border-destructive hover:text-destructive"
                >
                    Borrar
                </div>
            </AlertDialogTrigger>
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle> ¿Estás seguro? </AlertDialogTitle>
                    <AlertDialogDescription>
                        Esta acción no puede ser deshecha. Tu historia será
                        permanentemente borrada.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel>Cancelar</AlertDialogCancel>
                    <form @submit.prevent="deleteStory">
                        <Button :disabled="form.processing" type="submit">
                            Confirmar
                        </Button>
                    </form>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
        <!-- Guardar -->
        <Button form="submitStory" :disabled="form.processing" type="submit">
            Guardar cambios
        </Button>
    </div>
</template>
