// Website to PDF API – C# example (.NET 6+, top-level statements)
// Usage: dotnet new console -n Example && copy this file to Program.cs, then CAPTUREKIT_API_KEY=your-key dotnet run
using System.Text;
using System.Text.Json;

var apiKey = Environment.GetEnvironmentVariable("CAPTUREKIT_API_KEY") ?? throw new InvalidOperationException("Set CAPTUREKIT_API_KEY");
using var http = new HttpClient { Timeout = TimeSpan.FromSeconds(120) };
http.DefaultRequestHeaders.Add("x-api-key", apiKey);

var query = "url=" + Uri.EscapeDataString("https://github.com/seaweedfs/seaweedfs") + "&" +
    "format=" + Uri.EscapeDataString("pdf");
var response = await http.GetAsync("https://api.capturekit.dev/v1/capture" + (query.Length > 0 ? "?" + query : ""));
if (!response.IsSuccessStatusCode)
{
    Console.Error.WriteLine($"HTTP {(int)response.StatusCode}: {await response.Content.ReadAsStringAsync()}");
    return;
}

await File.WriteAllBytesAsync("page.pdf", await response.Content.ReadAsByteArrayAsync());
Console.WriteLine("Saved page.pdf");
