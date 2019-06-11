<template>
    <div>
        <v-text-field label="Search Name" v-model="search" append-icon="search"></v-text-field>
        <v-data-table
            :headers="headers"
            :items="namesLists"
            :search="search"
            :loading="loading"
            class="elevation-1"
            :no-data-text="'There is no name available'"
            :no-results-text="`There is no names result based on your keyword '${search}'`"
        >
            <template v-slot:items="props">
            <td class="text-xs-left">{{ props.item.fullname }}</td>
            <td class="text-xs-right">
                <v-tooltip slot="append" bottom>
                    <v-btn icon small slot="activator" color="primary" @click="edit({...props.item})">
                    <v-icon size="14">edit</v-icon>
                    </v-btn>
                    <span>Edit</span>
                </v-tooltip>

                <v-tooltip slot="append" bottom>
                    <v-btn icon small slot="activator" color="error" @click="remove({ id: props.item.id, index: props.item.index })">
                    <v-icon size="14">delete</v-icon>
                    </v-btn>
                    <span>Delete</span>
                </v-tooltip>
            </td>
            </template>
        </v-data-table>
    </div>
</template>

<script>
export default {
    data() { return {
        search: '',
        headers: [
            { text: 'FULLNAME', value: 'fullname' },
            { text: '', sortable: false }
        ]
    } },
    props: {
        items: Array,
        loading: Boolean
    },
    computed: {
        namesLists() {
            return this.items.map((row, key) => {
                row.index = key;
                return row;
            })
        }
    },
    methods: {
        edit( params ) {
            this.$emit('edit', params);
        },
        async remove( params ) {
            let res = await this.$confirm('Are you sure you want to remove this name?', { title: "Confirm Delete", buttonTrueText: "Confirm", buttonFalseText: "Cancel", persistent: true, icon: "warning", color: "warning" });
            if( res ) {
                this.$emit('remove', params);
            }
        }
    },
}
</script>