import Vuex from 'vuex'
import mutations from './mutations';
import state from './state';
import actions from './actions';
import getters from './getters';
export default new Vuex.Store({
	state,
	mutations,
	actions,
	getters
});