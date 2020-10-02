<template>
  <div>
    <div v-if="signedIn" class="rounded p-6 bg-gray-300 mt-2">
      <h2 class="mt-4 text-2xl text-center">Submit Review</h2>
      <form @submit.prevent="addReview">
        <div class="mb-4">
          <label class="block mb-2 text-sm font-bold text-gray-700" for="title">Title</label>
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
          <label class="block mb-2 text-sm font-bold text-gray-700" for="description">Description</label>
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
          <label class="block mb-2 text-sm font-bold text-gray-700" for="rating">Rating</label>
          <span class="star-rating">
            <input type="radio" name="rating" v-model="rating" v-bind:value="1" />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input type="radio" name="rating" v-model="rating" v-bind:value="2" />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input type="radio" name="rating" v-model="rating" v-bind:value="3" />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input type="radio" name="rating" v-model="rating" v-bind:value="4" />
            <i class="fa fas- fa-star text-yellow-600"></i>
            <input type="radio" name="rating" v-model="rating" v-bind:value="5" />
            <i class="fa fas- fa-star text-yellow-600"></i>
          </span>
        </div>
        <div class="mb-6 text-center">
          <button
            class="w-full bg-blue-500 active:bg-blue-800 text-white px-3 sm:px-4 py-2 rounded-full outline-none focus:outline-none mr-2 mb-1 uppercase shadow hover:shadow-md font-bold text-xs"
            type="submit"
          >Add Product Rating</button>
        </div>
      </form>
    </div>
    <p class="p-4" v-else>
      Please
      <a href="/login" class="text-blue-500">sign in</a> to add review
    </p>
  </div>
</template>
<script>
export default {
  props: ["data"],
  data() {
    return {
      product: this.data,
      rating: 5,
      description: "",
      title: "",
    };
  },
  methods: {
    addReview() {
      axios
        .post("/" + this.product.slug + "/ratings", {
          title: this.title,
          description: this.description,
          rating: this.rating
        })
        .then(({ data }) => {
          this.title = "";
          this.description = "";
          this.rating = "";
          flash("Your Review has been added");
          this.$emit("created", data);
        });
    }
  }
};
</script>
<style>
.star-rating {
  font-size: 0;
  white-space: nowrap;
  display: inline-block;
  height: 50px;
  overflow: hidden;
  position: relative;
  background: url("data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=");
  background-size: contain;
}
.star-rating i {
  opacity: 0;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  z-index: 1;
  background: url("data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=");
  background-size: contain;
}
.star-rating input {
  -moz-appearance: none;
  -webkit-appearance: none;
  opacity: 0;
  display: inline-block;
  height: 100%;
  margin: 0;
  padding: 0;
  z-index: 2;
  position: relative;
}
.star-rating input:hover + i,
.star-rating input:checked + i {
  opacity: 1;
}
.star-rating i ~ i {
  width: 40%;
}
.star-rating i ~ i ~ i {
  width: 60%;
}
.star-rating i ~ i ~ i ~ i {
  width: 80%;
}
.star-rating i ~ i ~ i ~ i ~ i {
  width: 100%;
}
::after,
::before {
  height: 100%;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  text-align: center;
  vertical-align: middle;
}

.star-rating {
  width: 250px;
}
.star-rating input,
.star-rating i {
  width: 20%;
}
.star-rating i ~ i {
  width: 40%;
}
.star-rating i ~ i ~ i {
  width: 60%;
}
.star-rating i ~ i ~ i ~ i {
  width: 80%;
}
.star-rating i ~ i ~ i ~ i ~ i {
  width: 100%;
}
</style>