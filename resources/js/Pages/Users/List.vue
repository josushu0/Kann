<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { UserPaginator } from '@/types'
import { Head, Link, router } from '@inertiajs/vue3'
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

	<AuthenticatedLayout>
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
							<Link
								:href="route('users.edit', slotProps.data.id)"
								class="size-8">
								<Avatar :image="slotProps.data.avatar" shape="circle" />
							</Link>
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
							new Date(slotProps.data.created_at).toLocaleString()
						}}</span>
					</template>
				</Column>
				<Column header="Actions">
					<template #body="slotProps">
						<div class="flex gap-2">
							<Link :href="route('users.edit', slotProps.data.id)">
								<Button icon="pi pi-pencil" text rounded severity="secondary" />
							</Link>
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
					:rows-per-page-options="[20, 40, 60]"
					:first="users.from - 1"
					pt:paginatorContainer:class="border dark:border-surface-800"
					pt:root:class="!rounded-none"
					@page="changePage">
					<template #start></template>
					<template #end>
						<Link :href="route('users.create')">
							<Button icon="pi pi-plus" />
						</Link>
					</template>
				</Paginator>
			</div>
		</div>
	</AuthenticatedLayout>
</template>
