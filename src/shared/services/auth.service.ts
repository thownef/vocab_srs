import { ApiService } from '.'

const BaseUrl = 'auth'

class AuthService {
  async login(body: Record<string, any>) {
    return ApiService.post(`${BaseUrl}/login`, body)
  }

  async register(body: Record<string, any>) {
    return ApiService.post(`${BaseUrl}/register`, body)
  }

  async getProfile() {
    return ApiService.get(`${BaseUrl}/me`)
  }
}

export default new AuthService()
