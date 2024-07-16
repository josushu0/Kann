<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { UserPaginator } from '@/types'
import { Head, router } from '@inertiajs/vue3'
import { PageState } from 'primevue/paginator'
import { useConfirm } from 'primevue/useconfirm'
import { ref } from 'vue'

const props = defineProps<{
	users: UserPaginator
	order: string
	sort: string
}>()

const container = ref<HTMLDivElement | null>(null)
const paginator = ref<HTMLDivElement | null>(null)
const sortField = ref(props.sort)

const sortOrder = (order: number | undefined) => {
	router.get(
		route('users.index', {
			_query: {
				page: props.users.current_page,
				rows: props.users.per_page,
				sort: sortField.value,
				order: order === 1 || order === null ? 'asc' : 'desc',
			},
		}),
		{},
		{ preserveState: true, preserveScroll: true }
	)
}

const changePage = (event: PageState) => {
	router.get(
		route('users.index', {
			_query: {
				page: event.page + 1,
				rows: event.rows,
				sort: sortField.value,
				order: props.order,
			},
		}),
		{},
		{ preserveState: true }
	)
}

const editUser = (id: string) => {
	router.get(route('users.edit', id))
}

const confirm = useConfirm()
const deleteUser = (id: string) => {
	confirm.require({
		message: 'Are you sure you want to delete the user?',
		header: 'Delete User',
		rejectProps: {
			label: 'Cancel',
			severity: 'secondary',
			outlined: true,
		},
		acceptProps: {
			label: 'Delete',
			severity: 'danger',
		},
		accept: () => {
			router.delete(route('users.destroy', id))
		},
	})
}
</script>

<template>
	<Head title="Users" />
	<AuthenticatedLayout title="Users" dashboard>
		<div ref="container" class="mx-auto h-full">
			<DataTable
				:value="users.data"
				striped-rows
				show-gridlines
				column-resize-mode="fit"
				resizable-columns
				scrollable
				removable-sort
				size="small"
				@update:sort-field="(field) => (sortField = field)"
				@update:sort-order="sortOrder"
				v-if="container && paginator"
				:scroll-height="container.clientHeight - paginator.clientHeight + 'px'">
				<Column field="name" header="Name" sortable>
					<template #body="slotProps">
						<div class="flex items-center gap-2">
							<Avatar :image="slotProps.data.avatar" shape="circle" />
							<span>{{ slotProps.data.name }}</span>
						</div>
					</template>
				</Column>
				<Column field="department" header="Department" sortable />
				<Column field="title" header="Title" sortable />
				<Column field="email" header="Email" sortable />
				<Column field="created_at" header="Created at" sortable>
					<template #body="slotProps">
						<span>{{
							new Date(slotProps.data.created_at).toLocaleDateString() +
							' ' +
							new Date(slotProps.data.created_at).toLocaleTimeString()
						}}</span>
					</template>
				</Column>
				<Column header="Actions">
					<template #body="slotProps">
						<div class="flex gap-2">
							<Button
								icon="pi pi-pencil"
								text
								rounded
								severity="secondary"
								@click="() => editUser(slotProps.data.id)" />
							<Button
								icon="pi pi-trash"
								text
								rounded
								severity="danger"
								@click="() => deleteUser(slotProps.data.id)" />
						</div>
					</template>
				</Column>
				<ConfirmDialog></ConfirmDialog>
			</DataTable>
			<div ref="paginator">
				<Paginator
					:total-records="users.total"
					:rows="users.per_page"
					:rows-per-page-options="[15, 30, 50]"
					:first="users.from - 1"
					pt:paginatorContainer:class="border dark:border-surface-800"
					pt:root:class="!rounded-none"
					@page="changePage"></Paginator>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
