export interface User {
	id: number
	name: string
	email: string
	avatar: string
	title: string
	department: string
	phone: string
	created_at: string
	updated_at: string
}

export interface Role {
	id: number
	name: string
	created_at: string
	updated_at: string
}

export interface Project {
	id: number
	name: string
	description: string
	start_date: Date
	due_date: Date
}

export type PageProps<
	T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
	auth: {
		user: User
	}
}

export interface Links {
	active: boolean
	label: string
	url: string
}

export interface UserPaginator {
	current_page: number
	data: User[]
	first_page_url: string
	from: number
	last_page: number
	last_page_url: string
	links: Links[]
	next_page_url: string
	path: string
	per_page: number
	prev_page_url: string
	to: number
	total: number
}

export interface RolesPaginator {
	current_page: number
	data: Role[]
	first_page_url: string
	from: number
	last_page: number
	last_page_url: string
	links: Links[]
	next_page_url: string
	path: string
	per_page: number
	prev_page_url: string
	to: number
	total: number
}
