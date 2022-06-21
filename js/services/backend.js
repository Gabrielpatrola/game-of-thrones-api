const axios = require("axios");

const api = axios.create({
  baseURL: "https://backend-challenge.hasura.app/v1/graphql",
  headers: {
    "content-type": "application/json",
    "x-hasura-admin-secret":
      "uALQXDLUu4D9BC8jAfXgDBWm1PMpbp0pl5SQs4chhz2GG14gAVx5bfMs4I553keV",
  },
});

class Backend {
  async store(name, imageUrl) {
    const storeData = {
      query: `mutation CreateCharacter {\n  insert_Character(objects: {name: \"${name}\", image_url: \"${imageUrl}\"}) {\n    returning {\n      id\n    }\n  }\n}`,
      operationName: "CreateCharacter",
    };

    try {
      const response = await api.post("", storeData);

      const payload = response.data.data;

      if (!payload) throw Error("Name is unique, choose another name!");

      return payload.insert_Character.returning[0].id;
    } catch (error) {
      throw Error(error);
    }
  }

  async storeQuote(id, quote) {
    const sanitazeQuote = quote.replaceAll('"', "");

    const storeData = {
      query: `mutation CreateQuote {\n  insert_Quote(objects: {text: \"${sanitazeQuote}\", character_id: \"${id}\"}) {\n    returning {\n      id\n      text\n    }\n  }\n}\n`,
      operationName: "CreateQuote",
    };

    try {
      const response = await api.post("", storeData);

      const payload = response.data.data;

      if (!payload) throw Error(response.data.errors[0].message, quote, id);

      return payload.insert_Quote.returning;
    } catch (error) {
      throw Error(error);
    }
  }

  async getAll() {
    const getData = {
      query:
        "{\n  Character {\n    Quotes {\n      text\n      id\n    }\n    id\n    image_url\n    name\n  }\n}\n",
    };

    try {
      const response = await api.post("", getData);

      const payload = response.data.data;

      if (!payload) throw Error(response.data.errors[0].message);

      return payload.Character;
    } catch (error) {
      throw Error(error);
    }
  }

  async delete() {
    const deleteData = {
      query:
        "mutation DeleteAll {\n  delete_Character(where: {id: {_gt: 0}}) {\n    affected_rows\n  }\n}\n",
      operationName: "DeleteAll",
    };

    try {
      const response = await api.post("", deleteData);

      const payload = response.data.data;

      if (!payload) throw Error(response.data.errors[0].message);

      return payload.delete_Character;
    } catch (error) {
      throw Error(error);
    }
  }
}

module.exports = new Backend();
