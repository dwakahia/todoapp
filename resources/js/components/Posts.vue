<template>
    <main class="sm:container sm:mx-auto sm:mt-10">
        <div class="container my-12 mx-auto px-4 md:px-12">

            <form action="" @submit.prevent="isEdit ? updatePost() : createPost()" class="my-4 w-full md:w-1/2 mx-auto"
                  method="post">
                <div class="flex flex-wrap my-3">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Title
                    </label>

                    <input id="title" type="text" class="form-input w-full" v-model="form.title"
                           :class="[error.title != null ? 'border-red-500': 'border-blue-500']"
                           autofocus>

                    <p v-if="error.title" class="text-red-500 text-xs italic mt-4">
                        {{ error.title }}
                    </p>
                </div>
                <div class="flex flex-wrap my-3">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2 sm:mb-4">
                        Description
                    </label>

                    <textarea class="form-input w-full" v-model="form.body"
                              :class="[error.body != null ? 'border-red-500': 'border-blue-500']"
                              name="description" id="description" cols="30" rows="3">

                            </textarea>


                    <p v-if="error.body" class="text-red-500 text-xs italic mt-4">
                        {{ error.body }}
                    </p>
                </div>
                <div class="flex">
                    <button @click.prevent="clearForm()"
                            class="w-full  font-bold whitespace-no-wrap p-3 rounded-lg   no-underline text-gray-100 bg-red-500 hover:bg-red-700 sm:py-4 mr-3">
                        Cancel
                    </button>
                    <button type="submit"
                            class="w-full  font-bold whitespace-no-wrap p-3 rounded-lg   no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                        {{ isEdit ? 'Update Post' : 'Add Post' }}
                    </button>
                </div>
            </form>

            <div class="flex flex-wrap -mx-1 lg:-mx-4">

                <div v-for="(post, index) in posts" :key="index"
                     class="my-1 p-2 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">

                    <div class="overflow-hidden rounded-lg shadow-lg flex flex-col h-full p-3">
                        <span class="my-1 font-extrabold">Title</span>
                        <p class="my-1 text-base">{{ post.title }}</p>
                        <span class="my-1 font-extrabold">Post</span>
                        <div class="mb-2 flex-grow">
                            {{ post.body }}
                        </div>

                        <hr>

                        <div
                            class="flex items-center justify-between  my-1 md:p-4">
                            <button class="bg-red-500 p-3 rounded-md text-white font-medium mr-2"
                                    @click="deletePost(post)">
                                Delete
                            </button>
                            <button class="bg-blue-700 p-3 rounded-md text-white font-medium"
                                    @click="editPost(post)">Edit
                            </button>
                        </div>

                    </div>

                </div>

            </div>
        </div>

    </main>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: '',
                body: '',
                userId: null
            },
            posts: [],
            isLoading: false,
            isEdit: false,
            error: {}
        }
    },
    mounted() {
        this.getPosts();
    },
    methods: {
        getPosts() {
            axios.get('/get-posts').then((response) => {
                this.posts = response.data.slice(0, 5);
                Vue.$toast.success('Posts fetched successfully', {position: 'top-right'});
            }).catch((error) => {
                Vue.$toast.error('something went wrong', {position: 'top-right'});
            })
        },
        editPost(post) {
            this.isEdit = true;
            this.form = {...post};
        },
        createPost() {
            this.error = {};
            if (this.validateForm()) {
                this.form.userId = 1;
                axios.post('/create-post', this.form).then((response) => {
                    console.log(response);
                    this.posts.unshift(response.data)
                    Vue.$toast.success('Post added successfully', {position: 'top-right'});
                    this.clearForm();
                }).catch((error) => {
                    Vue.$toast.error('something went wrong', {position: 'top-right'});
                })
            }
        },
        updatePost() {
            this.error = {};
            if (this.validateForm()) {
                axios.post('/update-post', this.form).then((response) => {
                    this.posts = this.posts.map((post) => {
                        if (post.id === this.form.id) {
                            return response.data;
                        }
                        return post;
                    });
                    Vue.$toast.success('Post updated successfully', {position: 'top-right'});
                    this.clearForm();
                }).catch((error) => {
                    Vue.$toast.error('something went wrong', {position: 'top-right'});
                })
            }
        },
        deletePost(post) {
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.get(`/delete-post/${post.id}`).then((response) => {
                        this.posts = this.posts.filter(response => response.id !== post.id)
                        this.$swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }).catch((error) => {
                        Vue.$toast.error('something went wrong', {position: 'top-right'});
                    })

                }
            })
        },
        validateForm() {
            if (!this.form.title) {
                this.error.title = 'title is required';
                return false;
            }
            if (!this.form.body) {
                this.error.body = 'body is required';
                return false;
            }

            return true;
        },
        clearForm() {
            this.error = {};
            this.isEdit = false;
            this.form = {
                title: '',
                body: '',
                userId: null
            }
        }
    }
}
</script>
