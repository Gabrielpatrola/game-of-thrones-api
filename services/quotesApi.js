const axios = require("axios");

const api = axios.create({
  baseURL: "https://api.gameofthronesquotes.xyz/v1/",
  headers: {
    "content-type": "application/json",
    accept: "application/json",
  },
});

class QuotesApi {
  async getAll(name) {
    const normalizedName = name.toLowerCase();

    try {
      const response = await api.get(`character/${normalizedName}`);

      const payload = response.data[0];

      if (!payload) throw Error("No data");

      return payload.quotes;
    } catch (error) {
      return error;
    }
  }
}

module.exports = new QuotesApi();
