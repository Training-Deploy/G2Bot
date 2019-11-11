module.exports = {
  root: true,
  env: {
    es6: true,
    node: true,
    browser: true
  },
  parserOptions: {
    parser: "babel-eslint",
    emacVersion: 6,
    sourceType: "module"
  },
  extends: [
    "standard",
    "eslint:recommended",
    "plugin:vue/recommended"
  ],
  rules: {
    "no-new": 0,
    "no-console": process.env.NODE_ENV === "production" ? "error" : "off",
    "no-debugger": process.env.NODE_ENV === "production" ? "error" : "off",
  },
  globals: {
    "axios": true,
    "Vue": true,
    "$": true,
    "jQuery": true,
    "_": true,
  },
};
