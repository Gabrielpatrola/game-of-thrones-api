const backend = require("./services/backend");
const charactersApi = require("./services/charactersApi");
const quotesApi = require("./services/quotesApi");

const arg = process.argv.slice(2)[0];

async function findCharacterByName() {
  const characters = await charactersApi.getAll();

  const findCharacter = characters.find((character) =>
    character.firstName.includes(arg)
  );

  if (!findCharacter)
    throw Error("Name not found in characters api! Try other name");

  return findCharacter;
}

async function createCharacter(name, imageUrl) {
  try {
    const response = backend.store(name, imageUrl);
    return response;
  } catch (error) {
    throw Error(error);
  }
}

async function insertQuote(id, quote) {
  try {
    const response = await backend.storeQuote(id, quote);
    return response;
  } catch (error) {
    throw Error(error);
  }
}

async function insertQuotes(id, quotes) {
  await Promise.all(
    quotes.map(async (item) => {
      const response = await insertQuote(id, item);
      console.log(response);
    })
  );
}

async function getQuotes(name) {
  return await quotesApi.getAll(name);
}

async function deleteData() {
  try {
    const response = await backend.delete();
    return console.log(response);
  } catch (error) {
    throw Error(error);
  }
}

async function list() {
  try {
    const response = await backend.getAll();
    return console.table(response);
  } catch (error) {
    throw Error(error);
  }
}

async function main() {
  if (!arg) {
    throw Error(
      "Please provide a character name or a command like: list, delete"
    );
  }
  switch (arg) {
    case "delete":
      await deleteData();
      break;
    case "list":
      await list();
      break;
    default:
      try {
        const character = await findCharacterByName(arg);

        const newCharacter = await createCharacter(
          character.fullName,
          character.imageUrl
        );

        const quotes = await getQuotes(character.firstName);

        if (quotes.length) await insertQuotes(newCharacter, quotes);

        return console.log("Character inserted in database");
      } catch (error) {
        console.log(error);
      }
      break;
  }
}

main();
