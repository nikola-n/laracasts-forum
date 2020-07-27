<template>
    <div>
        <div v-for="(reply, index) in items" :key="reply.id">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply @created="add" :endpoint="endpoint"></new-reply>

    </div>

</template>

<script>
    import Reply from "./Reply";
    import NewReply from "./NewReply";

    export default {
        //you can't modify a property
        props: ['data'],
        components: {Reply, NewReply},

        data() {
            return {
                items: this.data,
                endpoint: location.pathname + '/replies'
            }
        },

        methods: {
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
            },
            remove(index) {
                this.items.splice(index, 1);

                this.$emit('removed');

                flash('Reply was deleted');
            }
        }
    }
</script>
