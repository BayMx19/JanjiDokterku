<template>
    <Head title="Data Rekam Medis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Data Rekam Medis
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
                                :href="route('rm.create')"
                                class="inline-flex items-center rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                            >
                                <i class="fas fa-plus mr-2"></i>Tambah Rekam
                                Medis
                            </Link>

                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari nama pasien atau diagnosa..."
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
                                            @click="setSort('user.name')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Nama Pasien
                                            <SortIcon
                                                v-if="sortKey === 'user.name'"
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            @click="setSort('tanggal')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Tanggal
                                            <SortIcon
                                                v-if="sortKey === 'tanggal'"
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            @click="setSort('diagnosa')"
                                            class="cursor-pointer border border-gray-300 px-4 py-2 text-left select-none"
                                        >
                                            Diagnosa
                                            <SortIcon
                                                v-if="sortKey === 'diagnosa'"
                                                :order="sortOrder"
                                            />
                                        </th>
                                        <th
                                            class="border border-gray-300 px-4 py-2 text-left"
                                        >
                                            Tindakan
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
                                        v-for="data in filteredSortedRM"
                                        :key="data.id"
                                        class="even:bg-gray-50"
                                    >
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.user.name }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ formatTanggal(data.tanggal) }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.diagnosa }}
                                        </td>
                                        <td
                                            class="border border-gray-300 px-4 py-2"
                                        >
                                            {{ data.tindakan }}
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
                                                            'rm.edit',
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
                                    <tr v-if="filteredSortedRM.length === 0">
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
    RM: Array,
});

const search = ref("");
const sortKey = ref("tanggal");
const sortOrder = ref("desc");

function destroy(id) {
    if (confirm("Yakin ingin menghapus rekam medis ini?")) {
        router.delete(route("rm.destroy", id), {
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

// Sorting untuk nested 'user.name' kita buat sedikit custom
function getValue(data, key) {
    if (key === "user.name") {
        return data.user.name.toLowerCase();
    }
    return data[key] ?? "";
}

const filteredSortedRM = computed(() => {
    let data = props.RM;

    if (search.value.trim() !== "") {
        const q = search.value.toLowerCase();
        data = data.filter(
            (d) =>
                d.user.name.toLowerCase().includes(q) ||
                (d.diagnosa ?? "").toLowerCase().includes(q)
        );
    }

    data = data.slice().sort((a, b) => {
        let aVal = getValue(a, sortKey.value);
        let bVal = getValue(b, sortKey.value);

        if (sortKey.value === "tanggal") {
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
