const state = {
  product: [],
};

const mutations = {
  SET_PRODUCT: (state, product) => {
    state.product = product;
  },
};

const actions = {
  setProduct({ commit }, product) {
    commit('SET_PRODUCT', product);
  },
  setProductProperties({ commit, state }, payload) {
    const product = Object.assign({}, state.product);
    const productProperties = Object.assign([], product.properties);
    const property = Object.assign({}, productProperties[payload.index]);
    property.details = Object.assign([], payload.details);
    productProperties[payload.index] = Object.assign({}, property);
    product.properties = Object.assign([], productProperties);
    commit('SET_PRODUCT', product);
  },
  setProductVendors({ commit, state }, vendors) {
    const product = Object.assign({}, state.product);
    product.vendors = Object.assign([], vendors);
    commit('SET_PRODUCT', product);
  },
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
};
