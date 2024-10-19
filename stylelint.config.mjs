import standard from 'stylelint-config-standard-scss'

const config = {
  ...standard,
  rules: {
    ...standard.rules,
    'selector-class-pattern': '[a-zA-Z]+(_[a-zA-Z]+)*'
  }
}

export default config