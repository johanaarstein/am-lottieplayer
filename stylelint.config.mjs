import recommended from 'stylelint-config-recommended'

/**
 * @type {import('stylelint').Config}
  */
const config = {
  ...recommended,
  rules: {
    ...recommended.rules,
    'custom-property-pattern': null,
    'keyframes-name-pattern': null,
    'no-descending-specificity': [
      true, { severity: 'warning' },
    ],
    'selector-class-pattern': null,
  },
}

export default config