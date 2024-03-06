// UserInfo.js
import axios from 'axios';

export default {
  data() {
    return {
      userName: "",
    };
  },
  created() {
    this.fetchUserInfo();
  },
  methods: {
    fetchUserInfo() {
      const token = localStorage.getItem("token");
      axios
        .get("/api/profile", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          const userData = response.data.user;
          this.userName = userData.first_name;
        })
        .catch((error) => {
          console.error("Error fetching user information:", error);
        });
    },
  },
};
