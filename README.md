# Ollama PHP SDK

The Ollama PHP SDK provides the easiest way to integrate [Ollama](https://github.com/jmorganca/ollama) with your PHP projects.

## Getting Started

```
composer require juststeveking/ollama-php
```

## Usage

To get started with the Ollama SDK for PHP, firstly you will need to create a new SDK Instance. You can manually do this, or inject an instance of the SDK using a DI container.

```php
use JustSteveKing\Ollama\SDK;

$sdk = (new SDK(
    apiToken: '',
    url: 'https://api.your-api-instance.test/',
))->setup();

// Now you can interact with the Ollama SDK.
```

## API

There are a handful of methods you can call on the SDK, that will work directly with the Ollama API.

- `chat`: Generate the next message in a chat with a provided model. This is a streaming endpoint, so there will be a series of responses. Streaming can be disabled using "stream": false. The final response object will include statistics and additional data from the request.
- `create`: Create a model from a Modelfile. It is recommended to set modelfile to the content of the Modelfile rather than just set path. This is a requirement for remote create. Remote model creation must also create any file blobs, fields such as FROM and ADAPTER, explicitly with the server using Create a Blob and the value to the path indicated in the response.
- `generate`: Generate a response for a given prompt with a provided model. This is a streaming endpoint, so there will be a series of responses. The final response object will include statistics and additional data from the request.
- `pull`: Download a model from the ollama library. Cancelled pulls are resumed from where they left off, and multiple calls will share the same download progress.
- `push`: Upload a model to a model library. Requires registering for ollama.ai and adding a public key first.
- `delete`: Delete a model and its data.
- `list`: List models that are available locally.
- `embeddings`: Generate embeddings from a model

## Chat with a provided model

```php
use JustSteveKing\Ollama\SDK;
use JustSteveKing\Ollama\Enums\Role;
use JustSteveKing\Ollama\Requests\Chat;

$sdk = (new SDK(
    apiToken: '',
    url: 'https://api.your-api-instance.test/',
))->setup();

$sdk->chat(Chat::make([
  'model' => 'llama3',
  'messages' => [
    [
      'role' => Role::System,
      'content' => 'This is your system prompt.'
    ],
    [
      'role' => Role::User,
      'content' => 'This is your prompt.',
    ]
  ],
]));
```

This will return an instance of `ChatResponse`.

### Create a model from a Modelfile

```php
use JustSteveKing\Ollama\SDK;
use JustSteveKing\Ollama\Requests\CreateRequest;

$sdk = (new SDK(
    apiToken: '',
    url: 'https://api.your-api-instance.test/',
))->setup();

$sdk->create(CreateRequest::make([
  'model' => 'name of the model',
  'path' => 'Optional path to the modelfile',
  'modelfile' => 'String contents of the modelfile.',
  'stream' => false // Stream the response.
]));
```

This will return an instance of `StatusResponse`.

### Generate a response for a given prompt with a provided model

```php
use JustSteveKing\Ollama\SDK;
use JustSteveKing\Ollama\Requests\Prompt;

$sdk = (new SDK(
    apiToken: '',
    url: 'https://api.your-api-instance.test/',
))->setup();

$sdk->generate(Prompt::make([
  'model' => 'llama3',
  'prompt' => 'This is your prompt',
]));
```

This will return an instance of `GenerateResponse`.
