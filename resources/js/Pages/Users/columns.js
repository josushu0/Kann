import { h } from 'vue'
import DataTableColumnHeader from '@/Components/Table/DataTableColumnHeader.vue'
import DataTableRowActions from '@/Components/Table/DataTableRowActions.vue'

export const columns = [
  {
    accessorKey: 'name',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Name' }),
    cell: ({ row }) => h('div', row.getValue('name')),
  },
  {
    accessorKey: 'email',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Email' }),
    cell: ({ row }) => h('div', row.getValue('email')),
  },
  {
    accessorKey: 'department',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Department' }),
    cell: ({ row }) => h('div', row.getValue('department')),
  },
  {
    accessorKey: 'phone',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Phone' }),
    cell: ({ row }) => h('div', row.getValue('phone')),
  },
  {
    accessorKey: 'created_at',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Created' }),
    cell: ({ row }) => {
      const created_at = new Date(row.getValue('created_at')).toLocaleString()
      return h('div', created_at)
    }
  },
  {
    accessorKey: 'updated_at',
    header: ({ column }) => h(DataTableColumnHeader, { column, title: 'Updated' }),
    cell: ({ row }) => {
      const updated_at = new Date(row.getValue('updated_at')).toLocaleString()
      return h('div', updated_at)
    }
  },
  {
    id: 'actions',
    cell: ({ row }) => h(DataTableRowActions, {
      row,
      title: 'Delete user?',
      description: 'Are you sure you want to delete the user? Once the user is deleted, all of its resources and data will be permanently deleted.',
      button: {
        variant: 'destructive',
        text: 'Delete',
        disabled: false
      }
    }),
  },
]
