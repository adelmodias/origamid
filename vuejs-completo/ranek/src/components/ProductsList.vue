<template>
  <section class="products-container">
    <div class="productsList" v-if="products && products.length">
      <div
        class="productsList__item"
        v-for="product in products"
        :key="product.id"
      >
        <router-link to="/">
          <img
            v-if="products.photos"
            :src="product.photos[0]"
            :alt="product.photos[0].title"
          />
          <p class="price">{{ product.price }}</p>
          <h2 class="title">{{ product.name }}</h2>
          <p>{{ product.description }}</p>
        </router-link>
      </div>
    </div>
    <div v-else-if="products && products.length === 0">
      <p class="noRresults">Nenhum resultado encontrado.</p>
    </div>
  </section>
</template>

<script>
import { api } from "@/services.js";
import { serialize } from "@/helpers.js";
export default {
  data() {
    return {
      products: null,
      productsPerPage: 9
    };
  },
  computed: {
    url() {
      const query = serialize(this.$route.query);
      return `/products/?_limit=${this.productsPerPage}${query}`;
    }
  },
  watch: {
    url() {
      this.getProducts();
    }
  },
  methods: {
    getProducts() {
      api.get(this.url).then(response => (this.products = response.data));
    }
  },
  created() {
    this.getProducts();
  }
};
</script>

<style lang="scss" scoped>
.products-container {
  max-width: 1000px;
  margin: 0 auto;
}

.productsList {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  grid-gap: 30px;
  margin: 30px;

  &__item {
    box-shadow: 0 4px 8px rgba(30, 60, 90, 0.1);
    padding: 10px;
    background: #fff;
    border-radius: 4px;
    transition: 0.2s all;

    &:hover {
      box-shadow: 0 6px 12px rgba(30, 60, 90, 0.2);
      transform: scale(1.1);
      position: relative;
      z-index: 1;
    }

    img {
      border-radius: 4px;
      margin-bottom: 20px;
    }

    .title {
      margin-bottom: 10px;
    }

    .price {
      font-weight: bold;
      color: #e80;
    }
  }
}

.noRresults {
  text-align: center;
}
</style>
