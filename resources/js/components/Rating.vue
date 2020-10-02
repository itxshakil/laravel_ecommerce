<template>
  <div class="mt-2 border rounded bg-gray-100 p-4">
    <div v-if="!editing">
      <div v-text="title" class="font-semibold"></div>
      <i
        class="fa fas- fa-star text-yellow-600 mr-1"
        v-for="star in parseInt(stars)"
      ></i>
      <div class="mt-2" v-text="description"></div>
    </div>
    <div v-else>
      <form>
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-gray-700" for="title"
            >Title</label
          >
          <input
            class="w-full px-3 py-2 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
            id="title"
            type="text"
            placeholder="Add new heading"
            name="title"
            required
            autocomplete="title"
            v-model="title"
          />
        </div>
        <div class="mb-4">
          <label
            class="block mb-2 text-sm font-bold text-gray-700"
            for="description"
            >Description</label
          >
          <textarea
            class="w-full px-3 py-2 mb-3 text-sm leading-tight text-gray-700 border rounded shadow appearance-none focus:outline-none"
            id="description"
            name="description"
            required
            placeholder="Enter product description here"
            v-model="description"
          ></textarea>
        </div>
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-gray-700" for="rating"
            >Rating</label
          >
          <span class="star-rating">
            <input
              type="radio"
              name="rating"
              v-model="stars"
              v-bind:value="1"
            />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input
              type="radio"
              name="rating"
              v-model="stars"
              v-bind:value="2"
            />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input
              type="radio"
              name="rating"
              v-model="stars"
              v-bind:value="3"
            />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input
              type="radio"
              name="rating"
              v-model="stars"
              v-bind:value="4"
            />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input
              type="radio"
              name="rating"
              v-model="stars"
              v-bind:value="5"
            />
            <i class="fa fas- fa-star text-yellow-600"></i>
          </span>
        </div>
        <div class="flex">
          <button
            type="submit"
            class="bg-blue-500 active:bg-blue-400 text-gray-100 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
            @click="update"
          >
            Update
          </button>
          <button
            type="submit"
            class="bg-gray-100 active:bg-gray-200 text-gray-800 px-4 py-2 rounded outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs"
            @click="cancel"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
    <div>
      By-
      <span v-text="username" class="font-semibold"></span>
    </div>
    <div v-if="canEdit" class="flex">
      <div
        @click="editing = true"
        class="bg-blue-500 active:bg-blue-400 text-gray-100 px-2 py-1 rounded outline-none focus:outline-none mr-2 my-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs cursor-pointer"
      >
        Edit
      </div>
      <div
        class="bg-red-500 active:bg-red-400 text-gray-100 px-2 py-1 rounded outline-none focus:outline-none mr-2 my-1 uppercase shadow hover:shadow-md inline-flex items-center font-bold text-xs cursor-pointer"
        @click="remove"
      >
        Delete
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      editing: false,
      id: this.data.id,
      username: this.data.user.name,
      title: this.data.title,
      description: this.data.description,
      stars: this.data.rating,
      rating: this.data,
    };
  },
  computed: {
    canEdit() {
      if (!this.editing && auth_user) {
        return this.rating.user_id == auth_user.id;
      }
      return false;
    },
  },
  methods: {
    cancel() {
      this.editing = false;
      this.title = this.rating.title;
      this.description = this.rating.description;
      this.stars = this.rating.rating;
    },
    update() {
      this.editing = false;
      axios
        .patch("/ratings/" + this.id, {
          title: this.title,
          description: this.description,
          rating: this.stars,
        })
        .then(({ data }) => {
          flash("Your Review has been updated.");
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
    remove() {
      this.editing = false;
      axios
        .delete("/ratings/" + this.id)
        .then(({ data }) => {
          flash("Your Review has been deleted");
          this.$emit("deleted", this.id);
        })
        .catch((error) => {
          flash(error.response.data, "danger");
        });
    },
  },
};
</script>