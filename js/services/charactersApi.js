const axios = require("axios");

const api = axios.create({
  baseURL: "https://thronesapi.com/api/v2/Characters",
  headers: {
    "content-type": "application/json",
    accept: "application/json",
  },
});

class CharactersApi {
  async getAll() {
    try {
      const response = await api.get("");

      const payload = response.data;

      if (!payload) throw Error("No data");

      return payload;
    } catch (error) {
      throw Error(error);
    }
  }
}

module.exports = new CharactersApi();
