<template>
    <Head title="Detail Appointment" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Detail Appointment
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white p-6 shadow-md sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <!-- Pilih Pasien -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Pasien
                            </label>
                            <select
                                v-model="form.pasien_id"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                                disabled
                            >
                                <option value="">Pilih Pasien</option>
                                <option
                                    v-for="p in pasien"
                                    :key="p.id"
                                    :value="p.id"
                                >
                                    {{ p.name }}
                                </option>
                            </select>
                        </div>

                        <!-- Pilih Dokter -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Nama Dokter
                            </label>
                            <select
                                v-model="form.dokter_id"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                                disabled
                            >
                                <option value="">Pilih Dokter</option>
                                <option
                                    v-for="dokter in dokters"
                                    :key="dokter.id"
                                    :value="dokter.id"
                                >
                                    {{ dokter.user.name }} - -
                                    {{ dokter.spesialisasi }}
                                </option>
                            </select>
                            <div
                                v-if="form.errors.dokter_id"
                                class="text-sm text-red-600"
                            >
                                {{ form.errors.dokter_id }}
                            </div>
                        </div>

                        <!-- Input Jadwal (JSON) -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Jadwal Kunjungan
                            </label>
                            <div class="flex gap-2">
                                <input
                                    type="date"
                                    v-model="tanggal"
                                    class="rounded border-gray-300 shadow-sm"
                                    disabled
                                />
                                <input
                                    type="time"
                                    v-model="jamAwal"
                                    class="rounded border-gray-300 shadow-sm"
                                    disabled
                                />
                                <input
                                    type="time"
                                    v-model="jamAkhir"
                                    class="rounded border-gray-300 shadow-sm"
                                    disabled
                                />
                            </div>
                            <div
                                v-if="jadwalError"
                                class="text-sm text-red-600"
                            >
                                {{ jadwalError }}
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Ubah Status
                            </label>
                            <select
                                v-model="form.status"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            >
                                <option value="belum visit">Belum Visit</option>
                                <option value="sudah visit">Sudah Visit</option>
                            </select>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-4">
                            <label
                                class="block text-sm font-medium text-gray-700"
                            >
                                Catatan
                            </label>
                            <textarea
                                v-model="form.catatan"
                                rows="3"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                                disabled
                            ></textarea>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <Link
                                href="/appointments"
                                class="mr-4 rounded px-4 py-2 text-sm text-gray-600 hover:underline"
                            >
                                Batal
                            </Link>
                            <button
                                type="submit"
                                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                    <div class="mt-8">
                        <button
                            @click="openModal"
                            class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                        >
                            Tambah Rekam Medis
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Tambah Rekam Medis -->
        <teleport to="body">
            <div
                v-if="isModalOpen"
                class="fixed inset-0 bg-black flex items-center justify-center bg-opacity-50 z-50"
            >
                <div
                    class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg"
                    ref="modalContent"
                    @click.stop
                >
                    <h3 class="mb-4 text-lg font-semibold">
                        Tambah Rekam Medis
                    </h3>
                    <form @submit.prevent="submitRekamMedis">
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Tanggal</label
                            >
                            <input
                                type="date"
                                v-model="rekamMedis.tanggal"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Diagnosa</label
                            >
                            <textarea
                                v-model="rekamMedis.diagnosa"
                                rows="2"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            ></textarea>
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Tindakan</label
                            >
                            <textarea
                                v-model="rekamMedis.tindakan"
                                rows="2"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            ></textarea>
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Resep</label
                            >
                            <textarea
                                v-model="rekamMedis.resep"
                                rows="2"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            ></textarea>
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Catatan</label
                            >
                            <textarea
                                v-model="rekamMedis.catatan"
                                rows="2"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                            ></textarea>
                        </div>
                        <div class="mb-3">
                            <label
                                class="block text-sm font-medium text-gray-700"
                                >Pencatat</label
                            >
                            <input
                                type="text"
                                v-model="rekamMedis.pencatat"
                                class="mt-1 w-full rounded border-gray-300 shadow-sm"
                                required
                            />
                        </div>
                        <div class="flex justify-end gap-2 mt-4">
                            <button
                                type="button"
                                @click="closeModal()"
                                class="rounded border border-gray-300 px-4 py-2 text-gray-700 hover:bg-gray-100"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                class="rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                            >
                                Simpan Rekam Medis
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </teleport>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount } from "vue";
import { Link, useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const props = defineProps({
    pasien: Array,
    dokters: Array,
    appointment: Object,
    audits: Array,
});
// console.log(props.appointment.pasien.user.name);

const tanggal = ref("");
const jamAwal = ref("");
const jamAkhir = ref("");
const jadwalError = ref(null);
const isModalOpen = ref(false);
function openModal() {
    isModalOpen.value = true;
}
function closeModal() {
    isModalOpen.value = false;
}
const form = useForm({
    pasien_id: props.appointment.pasien_id ?? "",
    dokter_id: props.appointment.dokter_id ?? "",
    jadwal: props.appointment.jadwal
        ? typeof props.appointment.jadwal === "string"
            ? props.appointment.jadwal
            : JSON.stringify(props.appointment.jadwal)
        : JSON.stringify({ tanggal: "", jam_awal: "", jam_akhir: "" }),
    status: props.appointment.status ?? "",
    catatan: props.appointment.catatan ?? "",
});
const rekamMedis = useForm({
    appointment_id: props.appointment.id,
    tanggal: "",
    diagnosa: "",
    tindakan: "",
    resep: "",
    catatan: "",
    pencatat: "",
});

onMounted(() => {
    try {
        const jadwalObj = JSON.parse(form.jadwal);
        tanggal.value = jadwalObj.tanggal ?? "";
        jamAwal.value = jadwalObj.jam_awal ?? "";
        jamAkhir.value = jadwalObj.jam_akhir ?? "";
    } catch {
        tanggal.value = "";
        jamAwal.value = "";
        jamAkhir.value = "";
    }
});

function submit() {
    jadwalError.value = null;

    if (!tanggal.value || !jamAwal.value || !jamAkhir.value) {
        jadwalError.value = "Semua field jadwal harus diisi";
        return;
    }

    if (jamAwal.value >= jamAkhir.value) {
        jadwalError.value = "Jam awal harus lebih kecil dari jam akhir";
        return;
    }

    form.jadwal = JSON.stringify({
        tanggal: tanggal.value,
        jam_awal: jamAwal.value,
        jam_akhir: jamAkhir.value,
    });

    if (!["belum visit", "sudah visit"].includes(form.status)) {
        form.status = "belum visit";
    }

    form.put(route("appointments.update", props.appointment.id));
}
function submitRekamMedis() {
    rekamMedis.post(
        route("appointments.storeRekamMedis", props.appointment.id),
        {
            onSuccess: () => {
                alert("Rekam medis berhasil disimpan!");
                closeModal();
                rekamMedis.reset();
            },
            onError: () => {
                alert("Terjadi kesalahan saat menyimpan rekam medis.");
            },
        }
    );
}
</script>
