<template>
    <div :id="'reply-'+id" class="card mb-2">
        <div class="card-body">
            <div class="card-header">
                <div class="level">
                    <h5 class="flex">
                        <a :href="'/profiles/'+data.owner.name"
                           v-text="data.owner.name">
                        </a> said <span v-text="ago"></span>
                    </h5>
                    <div v-if="signedIn">
                        <favorite :reply="data"></favorite>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <label>
                        <textarea class="form-control" v-model="body"></textarea>
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-primary" @click="update">Update</button>
                <button class="btn btn-sm btn-link" @click="editing=false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>
        </div>

        <div class="card-footer level" v-if="canUpdate">
            <button class="btn btn-sm btn-secondary mr-1" @click="editing=true">Edit</button>
            <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
        </div>

    </div>
</template>

<script>
    import Favorite from "./Favorite";
    import moment from "moment";

    export default {
        props: ['data'],
        components: {Favorite},
        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body
            }
        },
        computed: {

            ago() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.authorize(user => this.data.user_id === user.id);
                // return this.data.user_id === window.App.user.id;
            }
        },
        methods: {
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                });
                this.editing = false;

                flash('updated!')
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
                // $(this.$el).fadeOut(300, () => {
                //     flash('Your reply has been deleted');
                // });
            }
        }
    };
</script>
