<script setup lang="ts">
import { ref } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { ScrollText } from "lucide-vue-next";
import { Button } from "@/Components/ui/button";
import { Textarea } from "@/Components/ui/textarea";
import { useToast } from "@/Components/ui/toast";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/Components/ui/dialog";
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

let isOpen = ref(false);
let isFetched = false;

const openDialog = () => {
    //Se obtiene la historia solo la primera vez, y tras enviar el formulario
    if (!isFetched) {
        fetchHistoria();
        isFetched = true;
    }
    isOpen.value = !isOpen.value;
};

const fetchHistoria = async () => {
    //Solo se obtiene la historia si ha iniciado sesión
    if (page.props.auth.user) {
        let historia = await axios.get(
            `/historia/${page.props.auth.user.id}/${props.kanji_id}`,
        );

        if (historia.data) {
            form.id = historia.data.id;
            form.historia = historia.data.historia;
        }
    }
};

const form = useForm({
    id: null,
    historia: "",
    user_id: page.props.auth.user?.id,
    kanji_id: props.kanji_id,
});

const submit = () => {
    form.post("/historia", {
        onSuccess: () => {
            toast({
                title: form.id ? "Historia actualizada" : "Historia creada",
            });
            isFetched = false;
            isOpen.value = false;
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
            isOpen.value = false;
        },
    });
};
</script>

<template>
    <Dialog :open="isOpen" @update:open="openDialog">
        <DialogTrigger as-child>
            <Button variant="secondary" class="shadow-md">
                <ScrollText class="mr-2" />
                Historia
            </Button>
        </DialogTrigger>
        <DialogContent class="sm:max-w-[500px]">
            <DialogHeader>
                <DialogTitle v-if="form.id"> Editar historia </DialogTitle>
                <DialogTitle v-else>Crear historia</DialogTitle>
                <DialogDescription>
                    Añade una historia a este kanji.
                </DialogDescription>
            </DialogHeader>
            <form id="submitStory" @submit.prevent="submit">
                <Textarea v-model="form.historia" class="min-h-32" />
            </form>
            <p class="mt-2 text-sm text-red-600" v-show="form.errors.historia">
                {{ form.errors.historia }}
            </p>
            <div class="flex justify-end mt-3 space-x-2">
                <AlertDialog v-if="form.id">
                    <AlertDialogTrigger as-child>
                        <Button variant="destructive"> Borrar </Button>
                    </AlertDialogTrigger>
                    <AlertDialogContent>
                        <AlertDialogHeader>
                            <AlertDialogTitle>
                                ¿Estás seguro?
                            </AlertDialogTitle>
                            <AlertDialogDescription>
                                Esta acción no puede ser deshecha. Tu historia
                                será permanentemente borrada.
                            </AlertDialogDescription>
                        </AlertDialogHeader>
                        <AlertDialogFooter>
                            <AlertDialogCancel>Cancelar</AlertDialogCancel>
                            <form @submit.prevent="deleteStory">
                                <Button>Confirmar</Button>
                            </form>
                        </AlertDialogFooter>
                    </AlertDialogContent>
                </AlertDialog>
                <Button form="submitStory" type="submit">
                    Guardar cambios
                </Button>
            </div>
        </DialogContent>
    </Dialog>
</template>
