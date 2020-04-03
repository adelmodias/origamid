<template>
  <section class="products-container">
    <div v-for="product in products" :key="product.id">
      <img v-if="products.photos" :src="product.photos[0]" :alt="product.photos[0].title" />
      <h2>{{product.name}}</h2>
      <p>{{product.price}}</p>
      <p>{{product.description}}</p>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      products: null
    };
  },
  methods: {
    getProducts() {
      fetch("http://localhost:3000/products")
        .then(response => response.json())
        .then(response => (this.products = response));
    }
  },
  created() {
    this.getProducts();
  }
};
</script>