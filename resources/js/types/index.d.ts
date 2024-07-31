export type Team = {
  id: string
  name: string
  personal: boolean
  owner?: User
  users?: User[]
};

export type User = {
  id: string
  name: string
  email: string
  avatar?: string
  verified: boolean
  team?: Team
};

export type Route = {
  name?: string
};

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user?: User;
  };
};
