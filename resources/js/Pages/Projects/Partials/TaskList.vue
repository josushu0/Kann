<script setup lang="ts">
import { List } from '@/types'
import { useForm } from '@inertiajs/vue3'
import { MenuMethods } from 'primevue/menu'
import { MenuItem } from 'primevue/menuitem'
import { useConfirm } from 'primevue/useconfirm'
import { ref } from 'vue'

const props = defineProps<{
	list: List
}>()

const listMenu = ref<MenuMethods | null>(null)
const confirm = useConfirm()
const menuItems = ref<MenuItem[]>([
	{
		label: 'Delete',
		icon: 'pi pi-trash',
		command: () => {
			confirm.require({
				message: 'Are you sure you want to delete the project?',
				header: 'Delete Project',
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
					form.delete(route('lists.destroy', props.list.id), {
						preserveState: false,
						preserveScroll: true,
					})
				},
			})
		},
	},
])

const form = useForm({
	name: props.list.name,
})

const handleUpdate = (closeCallback: Function) => {
	closeCallback()
	form.put(route('lists.update', props.list.id), {
		preserveState: false,
		preserveScroll: true,
	})
}
</script>

<template>
	<Card class="h-fit w-72 select-none" pt:title:class="!text-base">
		<template #title>
			<div class="flex items-start gap-1">
				<i class="list_drag_handle pi pi-ellipsis-v cursor-grab px-1 py-3" />
				<Inplace class="grow" pt:display:class="w-full max-w-44">
					<template #display>
						<p class="break-words">
							{{ list.name }}
						</p>
					</template>
					<template #content="{ closeCallback }">
						<label for="name" class="sr-only">Column name</label>
						<Textarea
							class="w-full"
							id="name"
							name="name"
							v-model="form.name"
							autofocus
							auto-resize
							:rows="1"
							:invalid="form.errors.name ? true : false"
							@keyup.enter="() => handleUpdate(closeCallback)"
							@keyup.esc="
								() => {
									closeCallback()
									form.reset()
								}
							"
							@focusout="
								() => {
									closeCallback()
									form.reset()
								}
							" />
					</template>
				</Inplace>
				<Button
					class="shrink-0"
					icon="pi pi-ellipsis-h"
					text
					severity="secondary"
					aria-haspopup="true"
					aria-controls="list_menu"
					@click="listMenu?.toggle" />
				<Menu ref="listMenu" id="list_menu" :popup="true" :model="menuItems" />
			</div>
		</template>

		<template #content>
			<div class="flex flex-col"></div>
		</template>
	</Card>
</template>
