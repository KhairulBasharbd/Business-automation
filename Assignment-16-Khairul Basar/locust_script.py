from locust import HttpUser, task, between

class WebsiteUser(HttpUser):
    wait_time = between(1, 7)  # Simulate users waiting between 1 and 7 seconds

    @task
    def load_homepage(self):
        self.client.get("/")  # Test the homepage

    @task(3)  # This task runs 3 times more often than the others
    def load_about_page(self):
        self.client.get("/posts")  # Test the post page