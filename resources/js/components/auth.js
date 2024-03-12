
export function isAuthenticated() {
    // Check if the authentication token is present in local storage
    const authToken = localStorage.getItem('token');
    return authToken !== null && authToken !== undefined;
  }

  export function redirectToLoginPage(router) {
    // Redirect to the login page
    router.push('/login'); // Assuming you're using Vue Router
    // Alternatively, you can use window.location.href = '/login';
  }
