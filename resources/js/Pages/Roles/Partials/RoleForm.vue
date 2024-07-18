<script setup lang="ts">
import InputError from '@/Components/InputError.vue'
import { Role } from '@/types'
import { Link, useForm } from '@inertiajs/vue3'

const props = defineProps<{
	role?: Role
	rolePermissions?: Role[]
	permissions: Role[]
	edit?: boolean
}>()

const created_at = props.role
	? new Date(props.role.created_at).toLocaleString()
	: ''
const updated_at = props.role
	? new Date(props.role.updated_at).toLocaleString()
	: ''

const leftPermissions = props.permissions.filter(
	(permission) =>
		!props.rolePermissions?.find((item) => item.id === permission.id)
)

const form = useForm({
	name: props.role ? props.role.name : '',
	permissions: [
		leftPermissions ?? props.permissions,
		props.rolePermissions ?? [],
	],
})

const handleSubmit = () => {
	if (props.edit && props.role) {
		form
			.transform((data) => ({
				...data,
				removePermissions: form.permissions[0].map(
					(permission) => permission.name
				),
				addPermissions: form.permissions[1].map(
					(permission) => permission.name
				),
			}))
			.put(route('roles.update', props.role.id))
	} else {
		form
			.transform((data) => ({
				...data,
				addPermissions: form.permissions[1].map(
					(permission) => permission.name
				),
			}))
			.post(route('roles.store'))
	}
}
</script>
<template>
	<form @submit.prevent="handleSubmit" class="space-y-4">
		<div class="flex flex-col">
			<label for="name">Role</label>
			<InputText
				id="name"
				name="name"
				type="text"
				v-model="form.name"
				required
				:invalid="form.errors.name ? true : false" />
			<InputError :message="form.errors.name" />
		</div>
		<div>
			<label for="permissions">Permissions</label>
			<PickList
				v-model="form.permissions"
				data-key="id"
				:show-target-controls="false"
				:show-source-controls="false">
				<template #option="{ option }"> {{ option.name }} </template>>
			</PickList>
		</div>
		<div v-if="role" class="grid grid-cols-2 gap-4">
			<div class="flex flex-col">
				<label for="created_at">Created at</label>
				<InputText
					id="created_at"
					name="created_at"
					type="text"
					v-model="created_at"
					disabled />
			</div>
			<div class="flex flex-col">
				<label for="updated_at">Updated at</label>
				<InputText
					id="updated_at"
					name="updated_at"
					type="text"
					v-model="updated_at"
					disabled />
			</div>
		</div>
		<div class="flex justify-end gap-2">
			<Link :href="route('roles.index')">
				<Button label="Cancel" type="button" severity="secondary" />
			</Link>
			<Button label="Save" type="submit" />
		</div>
	</form>
</template>
