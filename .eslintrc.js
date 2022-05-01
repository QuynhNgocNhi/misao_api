// https://eslint.org/docs/user-guide/configuring

module.exports = {
  root: true,
  parserOptions: {
    parser: '@babel/eslint-parser',
  },
  env: {
    browser: true,
  },
  extends: ['plugin:vue/recommended', 'plugin:prettier-vue/recommended'],
  // required to lint *.vue files
  plugins: ['vue', 'eslint-plugin-prettier'],
  // add your custom rules here
  rules: {
    'prettier-vue/prettier': [
      'error',
      {
        endOfLine: 'auto',
        singleQuote: true,
        semi: false,
        arrowParens: 'avoid',
        indent: ['error', 2],
        printWidth: 120,
      },
    ],
    'no-console': 'off',
    'no-useless-escape': 'off',
  },
  settings: {
    'import/resolver': {
      alias: {
        map: [['@', './resources/js']],
        extensions: ['.vue', '.js'],
      },
    },
  },
}
