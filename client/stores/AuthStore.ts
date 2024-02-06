import {acceptHMRUpdate, defineStore} from 'pinia'
// @ts-ignore
import {ref} from 'vue'
// @ts-ignore
import axios, {AxiosError, AxiosResponse} from "axios";

interface ApiResponse {
  success: boolean;
  "user_id" : number,
  "message" : string
}

export const useAuthStore = defineStore('AuthStore', () => {
    const token = ref('');
    const positions = ref([]);
    const errMsg = ref(null);
    const okMsg = ref(null);
    const loader = ref(false);
    const appConfig = useAppConfig();
    if (process.client) {
        const  positionsInLocalStorage = localStorage.getItem(" positions");
        if (positionsInLocalStorage) {
           console.log(JSON.parse(positionsInLocalStorage))
           positions.value = JSON.parse(positionsInLocalStorage);
        }
    }
    const loadToken = () =>{
        if(token.value.length >= 0) {
            // @ts-ignore
            axios.get(`${appConfig["publicUrl"]}/api/token`)
                .then((res:any) => {
                    token.value = res.data.token;
                })
        }
    }

  const setErrMsg = (msg:string|null) => errMsg.value = msg
  const setOkMsg = (msg:object|null) => okMsg.value = msg

    const loadPosition = async () =>{
      loader.value = true;
        // @ts-ignore
       await axios.get(`${appConfig["publicUrl"]}/api/positions`)
          .then((res:any) => {
              positions.value = res.data.positions;
            loader.value = false;
          })
    }

    const clearVar = () =>{
      setErrMsg(null);
      setOkMsg(null);
      token.value = '';
    }

    const register = async (form:object) =>{
      loader.value = true;
      const formData = new FormData()
      for (let [key, value] of Object.entries(form)) {
        // @ts-ignore
        formData.append(key, value);
      }
      await axios.post(`${appConfig["publicUrl"]}/api/register`, formData)
        .then((response: AxiosResponse<ApiResponse>) => {
          setOkMsg(response.data);
          loader.value = false;
        })
        .catch((err: AxiosError) => {
          setErrMsg(err.response.data.message);
          loader.value = false;
        });

    }
  watch(
    () => errMsg,
    (state: string|null) => {
      setTimeout(()=>setErrMsg(null), 5000);

    },
    {deep: true}
  );

    watch(
      () => positions,
      (state: { value: string | any[]; }) => {
          if (state.value.length > 0) {
              localStorage.setItem("position", JSON.stringify(state.value));
          }
      },
      {deep: true}
    );

    return {
        loader,
        positions,
        errMsg,
        okMsg,
        register,
        token,
        loadToken,
        loadPosition,
        setErrMsg,
        setOkMsg,
        clearVar

    };
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useAuthStore, import.meta.hot));
}
