import type { RouteLocationNormalized } from 'vue-router'

export const ResolveGuard = (guards: any[]) => {
  return async (to: RouteLocationNormalized, from: RouteLocationNormalized) => {
    for (const guard of guards) {
      const result = await guard(to, from)
      if (result !== undefined && result !== true) {
        return result
      }
    }
  }
}
