<template>
    <Head title="Data Janji Temu" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Data Janji Temu
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <!-- Baris tombol tambah dan search -->
                        <div
                            class="mb-4 flex flex-col gap-2 sm:flex-row sm:justify-between sm:items-center"
                        >
                            <Link
                                :href="route('appointments.create')"
                                class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Janji
                                Temu
                            </Link>

                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari pasien, dokter, status..."
                                class="w-full max-w-xs rounded border border-gray-300 px-3 py-2 text-sm placeholder-gray-400 focus:border-blue-500 focus:ring focus:ring-blue-300 focus:ring-opacity-50"
                            />
                        </div>

                        <div class="overflow-x-auto">
                            <table
                                class="w-full table-auto border-collapse border border-gray-200"
                            >
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            @click="setSort('pasien.user.name')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Nama Pasien
                                            <SortIcon
                                                v-if="
                                                    sortKey ===
                                                    'pasien.user.name'
                                                "
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            @click="setSort('dokter.user.name')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Dokter
                                            <SortIcon
                                                v-if="
                                                    sortKey ===
                                                    'dokter.user.name'
                                                "
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            @click="setSort('jadwal.tanggal')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Jadwal
                                            <SortIcon
                                                v-if="
                                                    sortKey === 'jadwal.tanggal'
                                                "
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            @click="setSort('status')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Status
                                            <SortIcon
                                                v-if="sortKey === 'status'"
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="data in filteredSortedAppointments"
                                        :key="data.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.pasien.user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.dokter.user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{
                                                formatTanggal(
                                                    data.jadwal.tanggal
                                                )
                                            }}
                                            | {{ data.jadwal.jam_awal }} -
                                            {{ data.jadwal.jam_akhir }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2 capitalize"
                                        >
                                            {{ data.status }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            <div
                                                class="flex items-center space-x-2"
                                            >
                                                <Link
                                                    :href="
                                                        route(
                                                            'appointments.detail',
                                                            data.id
                                                        )
                                                    "
                                                    class="text-green-600 hover:text-green-800"
                                                    title="Detail"
                                                >
                                                    <i
                                                        class="fas fa-info-circle"
                                                    ></i>
                                                </Link>
                                                <Link
                                                    :href="
                                                        route(
                                                            'appointments.edit',
                                                            data.id
                                                        )
                                                    "
                                                    class="text-blue-600 hover:text-blue-800"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </Link>
                                                <button
                                                    @click="destroy(data.id)"
                                                    class="text-red-600 hover:text-red-800"
                                                    title="Hapus"
                                                >
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr
                                        v-if="
                                            filteredSortedAppointments.length ===
                                            0
                                        "
                                    >
                                        <td
                                            colspan="5"
                                            class="text-center py-4 text-gray-500"
                                        >
                                            Tidak ada data.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Bisa tambah pagination nanti jika perlu -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";

const props = defineProps({
    appointments: Array,
});

const search = ref("");
const sortKey = ref("jadwal.tanggal");
const sortOrder = ref("desc");

function destroy(id) {
    if (confirm("Yakin ingin menghapus janji temu ini?")) {
        router.delete(route("appointments.destroy", id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log("Data berhasil dihapus.");
            },
            onError: () => {
                console.error("Gagal menghapus data.");
            },
        });
    }
}

function formatTanggal(tgl) {
    const date = new Date(tgl);
    const day = String(date.getDate()).padStart(2, "0");
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const year = date.getFullYear();
    return `${day}-${month}-${year}`;
}

function toggleSortOrder() {
    sortOrder.value = sortOrder.value === "asc" ? "desc" : "asc";
}

function setSort(key) {
    if (sortKey.value === key) {
        toggleSortOrder();
    } else {
        sortKey.value = key;
        sortOrder.value = "asc";
    }
}

function getValue(data, key) {
    // Support nested keys seperti pasien.user.name, dokter.user.name, jadwal.tanggal
    const keys = key.split(".");
    let val = data;
    for (const k of keys) {
        val = val?.[k];
        if (val === undefined) break;
    }
    if (typeof val === "string") {
        return val.toLowerCase();
    }
    return val ?? "";
}

const filteredSortedAppointments = computed(() => {
    let data = props.appointments;

    if (search.value.trim() !== "") {
        const q = search.value.toLowerCase();
        data = data.filter(
            (d) =>
                d.pasien.user.name.toLowerCase().includes(q) ||
                d.dokter.user.name.toLowerCase().includes(q) ||
                (d.status ?? "").toLowerCase().includes(q)
        );
    }

    data = data.slice().sort((a, b) => {
        let aVal = getValue(a, sortKey.value);
        let bVal = getValue(b, sortKey.value);

        if (sortKey.value === "jadwal.tanggal") {
            aVal = new Date(aVal);
            bVal = new Date(bVal);
            return sortOrder.value === "asc" ? aVal - bVal : bVal - aVal;
        } else {
            if (aVal < bVal) return sortOrder.value === "asc" ? -1 : 1;
            if (aVal > bVal) return sortOrder.value === "asc" ? 1 : -1;
            return 0;
        }
    });

    return data;
});
</script>

<script>
export default {
    components: {
        SortIcon: {
            props: ["order"],
            template: `
            <span class="inline-block ml-1 text-gray-400">
                <svg
                    v-if="order === 'asc'"
                    xmlns="http://www.w3.org/2000/svg"
                    class="inline h-3 w-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    class="inline h-3 w-3"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </span>
            `,
        },
    },
};
</script>
